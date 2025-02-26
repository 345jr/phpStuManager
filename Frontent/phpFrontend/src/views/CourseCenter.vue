<script setup>
import CourseCard from '@/components/CourseCard.vue';
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';

const api_courses = ref([]);
const selectedTag = ref(null);

// 获取所有唯一的标签
const availableTags = computed(() => {
  const tags = new Set(api_courses.value.map(course => course.course_tag));
  return ['全部', ...Array.from(tags)];
});

onMounted(async () => {
  try {
    const response = await axios.get('/api/courses');
    api_courses.value = response.data;
  } catch (error) {
    console.error('获取课程数据失败:', error);
  }
});


// 根据选中的标签筛选课程
const filteredCourses = computed(() => {
  if (!selectedTag.value || selectedTag.value === '全部') {
    return api_courses.value;
  }
  return api_courses.value.filter(course => course.course_tag === selectedTag.value);
});

// 点击标签时更新 selectedTag
function filterByTag(tag) {
  selectedTag.value = tag;
}
</script>

<template>
  <section class="bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <!-- 标题和标签分类区域 -->
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">选课中心</h2>
        <div class="relative group">
          <button class="bg-blue-500 text-white py-1 px-3 rounded inline-flex items-center">
            <i class=""></i>
            <span>标签分类</span>
          </button>
          <div
            class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded overflow-hidden max-h-0 group-hover:max-h-96 transition-all duration-300">
            <ul>
              <li v-for="tag in availableTags" :key="tag">
                <button 
                  class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                  :class="{ 'bg-gray-200': selectedTag === tag }"
                  @click="filterByTag(tag)"
                >
                  {{ tag }}
                </button>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- 课程列表 -->
      <div class="grid gap-6 md:grid-cols-2">
        <CourseCard 
          v-for="course in filteredCourses" 
          :key="course.course_id" 
          :course="course" 
        />
      </div>
    </div>
  </section>
</template>