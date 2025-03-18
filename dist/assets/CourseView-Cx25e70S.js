import{j as f,r as n,o as h,c as i,b as s,t as o,k as w,n as k,g as v,l as C,a as r}from"./index-CYIJ2KlJ.js";const B={class:"container mx-auto px-4 py-8 max-w-4xl"},V={class:"bg-white rounded-lg shadow-lg overflow-hidden"},E={key:0,class:"container mx-auto px-4 py-8 text-center"},N={key:1,class:"container mx-auto px-4 py-8 max-w-4xl"},R={class:"p-6"},S={class:"text-3xl font-bold text-gray-800 mb-4"},$={class:"grid grid-cols-1 md:grid-cols-2 gap-4 mb-6"},j={class:"flex items-center space-x-2"},z={class:"text-gray-600"},D={class:"flex items-center space-x-2"},I={class:"text-gray-600"},L={class:"flex items-center space-x-2"},M={class:"text-gray-600"},q={class:"flex items-center space-x-2"},A={class:"text-gray-600"},F={class:"flex items-center space-x-2"},G={class:"text-gray-600"},H={class:"mb-6"},J={class:"text-gray-600"},K={class:"mb-6"},O={class:"text-gray-600"},P={class:"flex items-center space-x-4"},Q=["disabled"],T={key:2,class:"container mx-auto px-4 py-8 text-center"},X={__name:"CourseView",setup(U){const g=f(),m=C(),c=g.params.id,e=n(null),d=n([]),p=n(!0),u=n(!1),l=n(""),_=async()=>{try{const a=await v.get("http://199.115.229.247:8080/api/courses");d.value=a.data;const t=d.value.find(x=>x.course_id==c);t?e.value=t:(console.warn(`未找到 course_id 为 ${c} 的课程`),e.value=null)}catch(a){console.error("获取课程详情失败:",a),e.value=null}finally{p.value=!1}},y=async a=>{if(e.value){u.value=!0;try{const t=await v.post("http://199.115.229.247:8080/api/enroll",{courseId:a});l.value="选课成功！"}catch(t){l.value="选课失败，请稍后重试",console.error("选课失败:",t)}finally{u.value=!1}}},b=()=>{m.push("/")};return h(()=>{_()}),(a,t)=>(r(),i("div",B,[s("div",V,[p.value?(r(),i("div",E,t[1]||(t[1]=[s("i",{class:"pi pi-spin pi-spinner text-4xl text-gray-500"},null,-1),s("p",{class:"mt-2 text-gray-600"},"加载中...",-1)]))):e.value?(r(),i("div",N,[s("div",{class:"relative"},[s("button",{class:"absolute top-1 right-4 bg-gray-800 text-white px-2 py-1 rounded-md hover:bg-gray-700 transition-colors duration-200",onClick:b},t[2]||(t[2]=[s("i",{class:"pi pi-arrow-right text-lg"},null,-1),s("span",{class:"absolute inset-0 rounded-md opacity-0 hover:opacity-100 transition-opacity duration-300",style:{"box-shadow":"0 0 8px 2px rgba(0, 123, 255, 0.7)"}},null,-1)]))]),s("div",R,[s("h1",S,o(e.value.course_name),1),s("div",$,[s("div",j,[t[3]||(t[3]=s("i",{class:"pi pi-users text-gray-500"},null,-1)),s("span",z,"最大人数: "+o(e.value.max_students),1)]),s("div",D,[t[4]||(t[4]=s("i",{class:"pi pi-user-plus text-gray-500"},null,-1)),s("span",I,"当前人数: "+o(e.value.current_num),1)]),s("div",L,[t[5]||(t[5]=s("i",{class:"pi pi-clock text-gray-500"},null,-1)),s("span",M,"开课时间: "+o(e.value.start_time),1)]),s("div",q,[t[6]||(t[6]=s("i",{class:"pi pi-hourglass text-gray-500"},null,-1)),s("span",A,"课时: "+o(e.value.class_hour),1)]),s("div",F,[t[7]||(t[7]=s("i",{class:"pi pi-user text-gray-500"},null,-1)),s("span",G,"授课老师: "+o(e.value.teacher),1)])]),s("div",H,[t[8]||(t[8]=s("h2",{class:"text-xl font-semibold text-gray-800 mb-2"},"课程简介",-1)),s("p",J,o(e.value.brief),1)]),s("div",K,[t[9]||(t[9]=s("h2",{class:"text-xl font-semibold text-gray-800 mb-2"},"详细描述",-1)),s("p",O,o(e.value.description),1)]),s("div",P,[s("button",{onClick:t[0]||(t[0]=x=>y(e.value.course_id)),disabled:u.value||e.value.current_num>=e.value.max_students,class:"flex items-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200"},[t[10]||(t[10]=s("i",{class:"pi pi-check"},null,-1)),s("span",null,o(u.value?"选课中...":"立即选课"),1)],8,Q),l.value?(r(),i("span",{key:0,class:k(l.value.includes("成功")?"text-green-500":"text-red-500")},o(l.value),3)):w("",!0)])])])):(r(),i("div",T,t[11]||(t[11]=[s("p",{class:"text-red-500"},"未找到课程信息",-1)])))])]))}};export{X as default};
