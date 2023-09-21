// 모든 <a> 요소 선택
var movieList = document.querySelectorAll(".movie-list li a");

// 각 <a> 요소에 이벤트 리스너 추가
movieList.forEach(function(a) {
  a.addEventListener("click", function() {
    // 모든 <a> 요소의 background-color 속성을 white로 변경
    movieList.forEach(function(a) {
      a.style.backgroundColor = "rgba(0,0,0,0)";
      a.classList.remove('selected');
    });

    // 선택한 <a> 요소의 background-color 속성을 yellow로 변경
    this.classList.add('selected');
    this.style.backgroundColor = "yellow";
  });
});