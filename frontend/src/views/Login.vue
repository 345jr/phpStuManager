<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// 表单数据
const email = ref('');  // 改为 email 与后端参数一致
const password = ref('');
const role = ref('student');  // 默认角色为 student
const errorMessage = ref('');

// 路由实例
const router = useRouter();

// 登录处理函数
const handleLogin = async () => {
  try {
    const response = await axios.post('/api/login', {
      email: email.value,
      password: password.value,
      role: role.value
    },
    {
      withCredentials: true
    });
    
    if (response.data.success) {
      router.push('/Me');
    } else {
      errorMessage.value = '登录信息错误';
    }
  } catch (error) {
    errorMessage.value = '登录失败，请稍后重试';
    console.error('登录错误:', error);
  }
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
      <h2 class="text-2xl font-bold text-center mb-6">登录</h2>
      <form @submit.prevent="handleLogin">
        <!-- 邮箱输入 -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-medium mb-2">邮箱</label>
          <input
            v-model="email"
            type="email"
            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="请输入邮箱"
            required
          />
        </div>

        <!-- 密码输入 -->
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-medium mb-2">密码</label>
          <input
            v-model="password"
            type="password"
            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="请输入密码"
            required
          />
        </div>

        <!-- 角色选择 -->
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-medium mb-2">角色</label>
          <div class="flex space-x-4">
            <label class="flex items-center">
              <input
                v-model="role"
                type="radio"
                value="student"
                class="mr-2 text-blue-500 focus:ring-blue-500"
              />
              <span class="text-gray-700">学生</span>
            </label>
            <label class="flex items-center">
              <input
                v-model="role"
                type="radio"
                value="admin"
                class="mr-2 text-blue-500 focus:ring-blue-500"
              />
              <span class="text-gray-700">管理员</span>
            </label>
          </div>
        </div>

        <!-- 错误信息 -->
        <div v-if="errorMessage" class="text-red-500 text-sm mb-4 text-center">
          {{ errorMessage }}
        </div>

        <!-- 提交按钮 -->
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors duration-200"
        >
          登录
        </button>
      </form>
    </div>
  </div>
</template>