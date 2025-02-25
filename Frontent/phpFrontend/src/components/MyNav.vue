<script setup>
// import { useRouter } from 'vue-router'
// // 获取路由实例
// // const router = useRouter()
// // // 可选：定义导航跳转方法
// // const navigateTo = (path) => {
// //     router.push(path)
// // }
</script>

<template>
    <nav class="bg-gradient-to-r from-gray-800 to-gray-900 p-4 shadow-xl">
      <div class="container mx-auto flex justify-between items-center">
        <!-- 渐变标题 -->
        <router-link 
          to="/" 
          class="text-xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent
                transition-all duration-500 hover:scale-105 hover:bg-gradient-to-r hover:from-cyan-400 hover:to-blue-400">
          学生选课系统
        </router-link>
  
        <!-- 导航链接组 -->
        <div class="flex space-x-8">
          <router-link 
            to="/"
            class="relative text-gray-300 transition-all duration-300 hover:text-white
                   hover:drop-shadow-[0_2px_10px_rgba(96,165,250,0.6)] group"
            active-class="!text-white font-semibold">
            <span class="group-hover:scale-105 transition-transform">选课中心</span>
            <div class="absolute -bottom-1 left-0 w-0 h-[2px] bg-cyan-400 transition-all group-hover:w-full"></div>
          </router-link>
  
          <router-link 
            to="/Me"
            class="relative text-gray-300 transition-all duration-300 hover:text-white
                   hover:drop-shadow-[0_2px_10px_rgba(96,165,250,0.6)] group"
            active-class="!text-white font-semibold">
            <span class="group-hover:scale-105 transition-transform">个人中心</span>
            <div class="absolute -bottom-1 left-0 w-0 h-[2px] bg-cyan-400 transition-all group-hover:w-full"></div>
          </router-link>
  
          <router-link 
            to="/About"
            class="relative text-gray-300 transition-all duration-300 hover:text-white
                   hover:drop-shadow-[0_2px_10px_rgba(96,165,250,0.6)] group"
            active-class="!text-white font-semibold">
            <span class="group-hover:scale-105 transition-transform">关于</span>
            <div class="absolute -bottom-1 left-0 w-0 h-[2px] bg-cyan-400 transition-all group-hover:w-full"></div>
          </router-link>
        </div>
      </div>
    </nav>
  </template>
  