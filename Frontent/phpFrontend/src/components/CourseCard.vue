<script setup>
import { defineProps } from 'vue';
import { RouterLink } from 'vue-router';

const props = defineProps({
  course: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <img :src="course.course_id" alt="Course Image" class="w-full h-40 object-cover">
    <div class="p-4">
      <h3 class="text-lg font-semibold text-gray-800">{{ course.course_name }}</h3>
      <p class="text-sm text-gray-500 mt-1">最大选课人数{{ course.max_students }} | 当前已选人数 {{ course.current_num }}</p>
      <p class="text-sm text-gray-500 mt-1">课程标签 :{{ course.course_tag }}</p>
      <p class="text-sm text-gray-600 mt-2">授课老师: {{ course.teacher }}</p>
      <p class="text-sm text-gray-600 mt-2">开课时间: {{ course.start_time }} | 课时 :{{ course.class_hour }}</p>
      <RouterLink :to="`/course/${course.course_id}`" class="text-blue-500 hover:underline mt-2 block">
        查看详情
      </RouterLink>
    </div>
  </div>
</template>


