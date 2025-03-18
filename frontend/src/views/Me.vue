<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();

const enrolledCourses = ref([]);
const StudentInfo = ref({});


// 获取已选课程
const fetchEnrolledCourses = async () => {
  try {
    const response = await axios.get('http://199.115.229.247:8080/api/enrolledCourses', {
      withCredentials: true  
    });
    enrolledCourses.value = response.data;
    console.log(enrolledCourses.value);
  } catch (error) {
    console.error('获取已选课程失败:', error);
  }
};

//获取学生信息
const fetchStudentInfo = async () => {
  try {
    const response = await axios.get('http://199.115.229.247:8080/api/studentInfo', {
      withCredentials: true  
    });
    StudentInfo.value = response.data;
  } catch (error) {
    console.error('获取学生信息失败:', error);
  }
};
// 退课功能
const unenrollCourse = async (courseId) => {
  try {
    await axios.post(`http://199.115.229.247:8080/api/unenroll`, {
      courseId,
    });
    alert('退课成功');
    fetchEnrolledCourses(); // 刷新课程列表
  } catch (error) {
    console.error('退课失败:', error);
    alert('退课失败');
  }
};

// 退出登录功能
const handleLogout = async () => {
  try {
    const response = await axios.post('/api/logout', {}, {
      withCredentials: true // 支持会话
    });
    if (response.status === 200) {
      
      localStorage.removeItem('token');
      localStorage.removeItem('student');
      router.push('/');
    } else {
      alert('退出登录失败: ' + response.data.message);
    }
  } catch (error) {
    console.error('退出登录失败:', error);
    alert('退出登录失败');
  }
};

// 页面加载时获取数据
onMounted(() => {
  fetchEnrolledCourses();
  fetchStudentInfo();
});
</script>

<template>
  <div class="bg-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
      <!-- 学生信息 -->
      <div class="bg-white shadow-md rounded-lg p-6 mb-8 flex items-center space-x-6">
        <img src="../../public/img/user.svg" alt="学生头像" class="w-24 h-24 rounded-full object-cover">
        <div>
          <h1 class="text-2xl font-bold text-gray-800">姓名 :{{ StudentInfo.name }}</h1>
          <p class="text-gray-600">学号: {{ StudentInfo.id }}</p>
          <p class="text-gray-600">账号: {{ StudentInfo.email }}</p>
        </div>
        <!-- 退出登录按钮 -->
        <button 
          @click="handleLogout" 
          class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition-colors"
        >
          退出登录
        </button>
      </div>

      <!-- 已选课程 -->
      <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">已选课程</h2>
        <div v-if="enrolledCourses.length > 0" class="space-y-4">
          <div v-for="course in enrolledCourses" :key="course.course_id" class="flex justify-between items-center p-4 bg-gray-50 rounded-md">
            <div>
              <h3 class="text-lg font-semibold text-gray-800">课程名字 :{{ course.course_name }}</h3>
              <p class="text-sm text-gray-500">开课时间: {{ course.start_time }} 课时 : {{ course.class_hour }}</p>
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