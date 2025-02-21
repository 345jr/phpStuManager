<script setup>
import CourseCard from '@/components/CourseCard.vue';
import axios from 'axios';
// import Data from '@/data.json'
import { ref , onMounted } from 'vue';
const api_courses = ref([]);
onMounted(async () => {
  try {
    const response = await axios.get('api/student/courses.php');
    api_courses.value = response.data.courses;
    console.log(api_courses.value);
  } catch (error) {
    console.error('获取课程数据失败:', error);
  }
});

// const courses = ref(Data);
</script>

<template>
  <section class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">选课中心</h2>
      <div class="grid gap-6 md:grid-cols-2">
        <CourseCard v-for="course in api_courses" :key="course.course_id" :course="course" />
      </div>
    </div>
  </section>
</template>