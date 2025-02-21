<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

// 获取路由参数
const route = useRoute();
const courseId = route.params.id;

// 课程数据和选课状态
const course = ref(null);
const isEnrolled = ref(false);

// 获取课程详情
const fetchCourseDetail = async () => {
  try {
    const response = await axios.get(`/api/courses/${courseId}`);
    course.value = response.data.courses;
  } catch (error) {
    console.error('获取课程详情失败:', error);
  }
};

// 选课操作
const enrollCourse = async () => {
  try {
    await axios.post(`/api/enroll/${courseId}`);
    isEnrolled.value = true;
    alert('选课成功');
  } catch (error) {
    console.error('选课失败:', error);
    alert('选课失败');
  }
};

// 退课操作
const unenrollCourse = async () => {
  try {
    await axios.post(`/api/unenroll/${courseId}`);
    isEnrolled.value = false;
    alert('退课成功');
  } catch (error) {
    console.error('退课失败:', error);
    alert('退课失败');
  }
};

// 组件挂载时加载数据
onMounted(() => {
  fetchCourseDetail();
  isEnrolled.value = false; // 假设初始未选课，实际应通过 API 检查
});
</script>

<template>
  <div v-if="course" class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
      <!-- 课程图片 -->
      <img :src="course.img" alt="课程图片" class="w-full h-64 object-cover">

      <!-- 课程信息 -->
      <div class="p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ course.title }}</h1>
        <p class="text-gray-600 mb-4">{{ course.description }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <div>
            <p class="text-sm text-gray-500">开课时间</p>
            <p class="text-lg font-semibold text-gray-800">{{ course.startTime }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">教师</p>
            <p class="text-lg font-semibold text-gray-800">{{ course.teacher }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">课时</p>
            <p class="text-lg font-semibold text-gray-800">{{ course.duration }} 小时</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">难度</p>
            <p class="text-lg font-semibold text-gray-800">{{ course.level }}</p>
          </div>
        </div>

        <!-- 操作按钮 -->
        <div class="flex space-x-4">
          <button
            v-if="!isEnrolled"
            @click="enrollCourse"
            class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors"
          >
            选课
          </button>
          <button
            v-if="isEnrolled"
            @click="unenrollCourse"
            class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition-colors"
          >
            退课
          </button>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="text-center text-gray-500">加载中...</div>
</template>