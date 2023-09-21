var today = new Date();

var year = document.getElementById("year");
var month = document.getElementById("month");

year.innerHTML = today.getFullYear();
month.innerHTML = today.getMonth()+1;

var dateList = document.getElementById("dateList");
// var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
var lastDay = new Date(today.getFullYear(), today.getMonth()+1, 0);
var weekDays = ['일', '월', '화', '수', '목', '금', '토'];

for (var i = today.getDate(); i <= lastDay.getDate(); i++) {
    // 새로운 <li> 요소 생성
    var li = document.createElement("li");
    li.classList.add("day");
  
    // 날짜 값과 요일 값 생성
    var date = new Date(today.getFullYear(), today.getMonth(), i);
    var weekDay = weekDays[date.getDay()];
    var dateString = i;

    if (weekDay == '토') {
        li.classList.add("day-sat");
    } else if (weekDay == '일') {
        li.classList.add("day-sun");
    }
  
    // <a> 요소 생성
    var a = document.createElement("a");
  
    // <a> 요소의 href 속성 설정
    a.href = "#"; // 예시로 #으로 설정함

    // <a> 요소에 onclick 속성 추가
    a.setAttribute("onclick", "return false;");

    // <a> 태그에 data-date 속성 추가하고 값은 해당 날짜로 설정함
    a.setAttribute("data-date", i);
  
    // 날짜 출력을 위한 <span> 요소 생성
    var dateSpan = document.createElement("span");
    dateSpan.setAttribute("data-date", i);
  
    // 요일 출력을 위한 <span> 요소 생성
    var weekDaySpan = document.createElement("span");
  
    // 클래스 이름 추가
    dateSpan.classList.add("day");
    weekDaySpan.classList.add("dayweek");
  
    // <span> 요소 내부에 날짜 값과 요일 값 추가
    dateSpan.textContent = dateString;
    weekDaySpan.textContent = weekDay;
  
    // <span> 요소를 <a> 요소 내부에 추가
    a.appendChild(weekDaySpan);
    a.appendChild(dateSpan);
  
    // <li> 요소 내부에 <a> 요소 추가
    li.appendChild(a);
  
    // <ul> 요소 내부에 <li> 요소 추가
    dateList.appendChild(li);
}

// 모든 <a> 요소 선택
var aList = document.querySelectorAll("li.day a");

// 각 <a> 요소에 이벤트 리스너 추가
aList.forEach(function(a) {
  a.addEventListener("click", function() {
    // 모든 <a> 요소의 background-color 속성을 white로 변경
    aList.forEach(function(a) {
      a.style.backgroundColor = "rgba(0,0,0,0)";
      a.classList.remove("selected");
    });

    // 선택한 <a> 요소의 background-color 속성을 yellow로 변경
    this.style.backgroundColor = "yellow";
    this.classList.add("selected");
  });
});