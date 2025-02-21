import { createRouter, createWebHistory } from "vue-router";
import Login from "@/views/Login.vue";
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

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem("token");
  if (to.meta.requiresAuth && !token) {
    next("/login"); // 未登录，跳转到登录页
  } else {
    next(); // 已登录或访问无需认证的页面
  }
});

export default router;
