<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

// 表单数据
const username = ref('');
const password = ref('');
const errorMessage = ref('');

// 路由实例
const router = useRouter();

// 登录处理函数
const handleLogin = async () => {
  try {
    const response = await axios.post('/api/student/login.php',{
      email: username.value,
      password: password.value,    
    });
    console.log(response.data);
    if (response.data.success) {

      localStorage.setItem('token', response.data.token);
      localStorage.setItem('student', JSON.stringify(response.data.student));
      
      router.push('/Me'); 
    } else {
      errorMessage.value = '用户名或密码错误';
    }
  } catch (error) {
    errorMessage.value = '登录失败，请稍后重试';
  }
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
      <h2 class="text-2xl font-bold text-center mb-6">登录</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-gray-700">用户名</label>
          <input
            v-model="username"
            type="text"
            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="请输入用户名"
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">密码</label>
          <input
            v-model="password"
            type="password"
            class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="请输入密码"
          />
        </div>
        <div v-if="errorMessage" class="text-red-500 text-sm mb-4">{{ errorMessage }}</div>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors"
        >
          登录
        </button>
      </form>
    </div>
  </div>
</template>