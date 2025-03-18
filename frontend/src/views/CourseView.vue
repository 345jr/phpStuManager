<script setup>
import { useRoute } from 'vue-router';
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const courseId = route.params.id;
parseInt(courseId);

// 课程数据
const course = ref(null);
const courses = ref([]);
const isLoading = ref(true);
// 选课状态
const isEnrolling = ref(false);
const enrollStatus = ref('');

// 获取课程详情
const fetchCourse = async () => {
  try {
    const response = await axios.get(`http://199.115.229.247:8080/api/courses`);
    courses.value = response.data;
    const matchedCourse = courses.value.find(c => c.course_id == courseId);
    if (matchedCourse) {
      course.value = matchedCourse;
    } else {
      console.warn(`未找到 course_id 为 ${courseId} 的课程`);
      course.value = null;
    }
  } catch (error) {
    console.error('获取课程详情失败:', error);
    course.value = null;
  } finally {
    isLoading.value = false;
  }
};

// 选课功能
const enrollCourse = async (courseId) => {
  if (!course.value) return; 
  isEnrolling.value = true;
  try {
    const response = await axios.post('http://199.115.229.247:8080/api/enroll', {courseId});
    enrollStatus.value = '选课成功！';
  } catch (error) {
    enrollStatus.value = '选课失败，请稍后重试';
    console.error('选课失败:', error);
  } finally {
    isEnrolling.value = false;
  }
};

const goBack = () => {
  router.push('/');
};

// 组件挂载时获取数据
onMounted(() => {
  fetchCourse();
});
</script>

<template>
  <div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- 课程头部 -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
      <div v-if="isLoading" class="container mx-auto px-4 py-8 text-center">
        <i class="pi pi-spin pi-spinner text-4xl text-gray-500"></i>
        <p class="mt-2 text-gray-600">加载中...</p>
      </div>
      <div v-else-if="course" class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="relative">
          <!-- <img :src="`${course.course_id}.jpg`" alt="Course Image" class="w-full h-64 object-cover"> -->
          <button class="absolute top-1 right-4 bg-gray-800 text-white px-2 py-1 rounded-md hover:bg-gray-700 transition-colors duration-200" @click="goBack">
            <i class="pi pi-arrow-right text-lg"></i>
            <span class="absolute inset-0 rounded-md  opacity-0 hover:opacity-100 transition-opacity duration-300"
              style="box-shadow: 0 0 8px 2px rgba(0, 123, 255, 0.7);"></span>
          </button>
        </div>
        <!-- 课程主要信息 -->
        <div class="p-6">
          <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ course.course_name }}</h1>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="flex items-center space-x-2">
              <i class="pi pi-users text-gray-500"></i>
              <span class="text-gray-600">最大人数: {{ course.max_students }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="pi pi-user-plus text-gray-500"></i>
              <span class="text-gray-600">当前人数: {{ course.current_num }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="pi pi-clock text-gray-500"></i>
              <span class="text-gray-600">开课时间: {{ course.start_time }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="pi pi-hourglass text-gray-500"></i>
              <span class="text-gray-600">课时: {{ course.class_hour }}</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="pi pi-user text-gray-500"></i>
              <span class="text-gray-600">授课老师: {{ course.teacher }}</span>
            </div>
          </div>
          <!-- 课程简介 -->
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">课程简介</h2>
            <p class="text-gray-600">{{ course.brief }}</p>
          </div>
          <!-- 课程描述 -->
          <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">详细描述</h2>
            <p class="text-gray-600">{{ course.description }}</p>
          </div>
          <!-- 选课按钮 -->
          <div class="flex items-center space-x-4">
            <button @click="enrollCourse(course.course_id)" :disabled="isEnrolling || course.current_num >= course.max_students"
              class="flex items-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
              <i class="pi pi-check"></i>
              <span>{{ isEnrolling ? '选课中...' : '立即选课' }}</span>
            </button>
            <span v-if="enrollStatus" :class="enrollStatus.includes('成功') ? 'text-green-500' : 'text-red-500'">
              {{ enrollStatus }}
            </span>
          </div>
        </div>
      </div>
      <div v-else class="container mx-auto px-4 py-8 text-center">
        <p class="text-red-500">未找到课程信息</p>
      </div>
    </div>
  </div>
</template>

<style scoped></style>