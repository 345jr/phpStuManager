<script setup>
import { ref } from 'vue';

// 项目发展变化数据（示例）
const timeline = ref([
  {
    year: '2020',
    title: '项目启动',
    description: '项目正式启动，团队组建完成，开始规划核心功能。'
  },
  {
    year: '2021',
    title: '首次上线',
    description: '完成了学生登录和课程选择功能，系统首次上线供内部测试使用。'
  },
  {
    year: '2022',
    title: '功能扩展',
    description: '新增课程退选、学生信息管理功能，优化用户体验。'
  },
  {
    year: '2023',
    title: '全面部署',
    description: '系统在多所学校部署，新增多语言支持和移动端适配。'
  },
  {
    year: '2025',
    title: '智能化升级',
    description: '引入AI推荐课程功能,全面提升系统智能化水平。'
  }
]);
</script>

<template>
  <div class="bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <!-- 标题 -->
      <h1 class="text-4xl font-bold text-gray-800 text-center mb-12">关于项目</h1>

      <!-- 项目简介 -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-12">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">项目概述</h2>
        <p class="text-gray-600 leading-relaxed">
          这是一个学生课程管理系统，旨在为学生提供便捷的课程选择和管理体验。从最初的简单功能到如今的全面智能化，项目经历了多次迭代与升级。以下是我们的发展历程。
        </p>
      </div>

      <!-- 时间线 -->
      <div class="relative">
        <!-- 时间线中轴线 -->
        <div class="absolute w-1 bg-blue-500 h-full left-1/2 transform -translate-x-1/2"></div>

        <!-- 时间线项 -->
        <div v-for="(item, index) in timeline" :key="index" class="mb-12 flex items-center">
          <!-- 左侧/右侧内容 -->
          <div :class="[
            'w-1/2 px-6',
            index % 2 === 0 ? 'text-right' : 'order-last text-left'
          ]">
            <h3 class="text-xl font-semibold text-gray-800">{{ item.title }}</h3>
            <p class="text-gray-600">{{ item.description }}</p>
          </div>

          <!-- 时间点 -->
          <div class="w-1/2 flex justify-center">
            <div class="relative">
              <div class="w-4 h-4 bg-blue-500 rounded-full z-10"></div>
              <span class="absolute top-6 left-1/2 transform -translate-x-1/2 text-blue-700 font-bold">
                {{ item.year }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>