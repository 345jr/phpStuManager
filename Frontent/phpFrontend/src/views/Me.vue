<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// 学生信息
const student = ref({
  name: '',
  avatar: '',
  id: ''
});

// 已选课程列表
const enrolledCourses = ref([]);

// 获取学生信息
const fetchStudentInfo = async () => {
  try {
    const response = await axios.get('/api/student/info');
    student.value = response.data;
  } catch (error) {
    console.error('获取学生信息失败:', error);
  }
};

// 获取已选课程
const fetchEnrolledCourses = async () => {
  try {
    const response = await axios.get('/api/student/enrolled.php');
    enrolledCourses.value = response.data.courses;
  } catch (error) {
    console.error('获取已选课程失败:', error);
  }
};

// 退课功能
const unenrollCourse = async (courseId) => {
  try {
    await axios.delete(`/api/student/withdraw.php?course_id=${courseId}`);
    alert('退课成功');
    fetchEnrolledCourses(); // 刷新课程列表
  } catch (error) {
    console.error('退课失败:', error);
    alert('退课失败');
  }
};

// 页面加载时获取数据
onMounted(() => {
//   fetchStudentInfo();
  fetchEnrolledCourses();
});
</script>

<template>
  <div class="bg-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <!-- 学生信息 -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-8 flex items-center space-x-6">
        <img :src="student.avatar" alt="学生头像" class="w-24 h-24 rounded-full object-cover">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">{{ student.name }}</h1>
          <p class="text-gray-600">学号: {{ student.id }}</p>
        </div>
      </div>

      <!-- 已选课程 -->
      <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">已选课程</h2>
        <div v-if="enrolledCourses.length > 0" class="space-y-4">
          <div v-for="course in enrolledCourses" :key="course.course_id" class="flex justify-between items-center p-4 bg-gray-50 rounded-md">
            <div>
              <h3 class="text-lg font-semibold text-gray-800">{{ course.course_name }}</h3>
              <p class="text-sm text-gray-500">开课时间: {{ course.startTime }}</p>
              <p class="text-sm text-gray-500">教师: {{ course.teacher }}</p>
            </div>
            <button @click="unenrollCourse(course.course_id)" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors">
              退课
            </button>
          </div>
        </div>
        <div v-else class="text-center text-gray-500">暂无已选课程</div>
      </div>
    </div>
  </div>
</template>