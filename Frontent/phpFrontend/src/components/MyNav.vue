<script setup>
import { useRouter } from 'vue-router'

// 获取路由实例
const router = useRouter()

// 可选：定义导航跳转方法
const navigateTo = (path) => {
    router.push(path)
}
</script>

<template>
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- 左侧标题 -->
            <router-link to="/" class="text-white text-xl font-bold hover:text-gray-300">
                学生选课系统
            </router-link>

            <!-- 导航链接 -->
            <div class="space-x-6">
                <router-link to="/" class="text-white hover:text-gray-300 transition-colors duration-200"
                    active-class="text-blue-400 font-semibold">
                    选课中心
                </router-link>
                <router-link to="/Me" class="text-white hover:text-gray-300 transition-colors duration-200"
                    active-class="text-blue-400 font-semibold">
                    个人中心
                </router-link>
                <router-link to="/About" class="text-white hover:text-gray-300 transition-colors duration-200"
                    active-class="text-blue-400 font-semibold">
                    关于
                </router-link>
            </div>
        </div>
    </nav>
</template>
