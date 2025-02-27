import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Login.vue";
import axios from 'axios';

// 定义路由
const routes = [
  {
    path: "/login",
    name: "登录页",
    component:Login
  },
  {
    path: "/",
    name: "课程中心",
    component: () => import("../views/CourseCenter.vue"),

  },
  {
    path: "/course/:id",
    name: "课程详细页",
    component: () => import("../views/CourseView.vue"),
    meta: { requiresAuth: true } 
  },
  {
    path: "/Me",
    name: "个人中心",
    component: () => import("../views/Me.vue"),
    meta: { requiresAuth: true } 
  },
  {
    path: "/about",
    name: "About",
    component: () => import("../views/About.vue"),
  },
  {
    path: "/:catchAll(.*)",
    name: "not-found",
    component: () => import("../views/NotFound.vue"),
  },
];

// 创建路由实例
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from, next) => {
  // 如果页面需要认证
  if (to.meta.requiresAuth) {
    try {
      // 请求后端验证会话状态
      await axios.get('/api/check-session', {
        withCredentials: true // 携带 Cookie
      });
      next(); // 会话有效，继续导航
    } catch (error) {
      if (error.response?.status === 401) {
        localStorage.removeItem('token'); // 可选：清理 token
        next('/login'); // 会话无效，跳转登录页
      } else {
        console.error('检查会话失败:', error);
        next('/login'); // 其他错误也跳转登录页
      }
    }
  } else {
    next(); // 无需认证的页面直接放行
  }
});

export default router;
