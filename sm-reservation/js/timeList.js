var movieId;

function getTimeList() {
    // 선택한 영화와 날짜를 가져옴
    var selectedMovie = document.querySelector(".movie-list li a.selected");
    var selectedDate = document.querySelector("#dateList li a.selected");
  
    // 영화 ID와 날짜를 이용하여 DB에서 상영 시간 정보를 가져옴
    var selDate = selectedDate.getAttribute("data-date");
    movieId = selectedMovie.getAttribute("data-movieId");
        
    var requestUrl = `http://semin1127.dothome.co.kr/sm-reservation/php/getTime.php?movieId=${movieId}&selDate=${selDate}`;
  
    fetch(requestUrl)
    .then(response => response.json())
    .then(data => {
        if (data.length === 0) {
            var timeList = document.getElementById("timeList");
            timeList.innerHTML = "<p>해당되는 상영 정보가 존재하지 않습니다.</p>";
            return;
        }
        // 가져온 상영 시간 정보를 timeList에 추가함
        var timeList = document.getElementById("timeList");

        // 기존의 내용을 모두 지우는 부분
        timeList.innerHTML = "";

        data.forEach(time => {
            var li = document.createElement("li");
            li.classList.add('time');
            var a = document.createElement("a");
            var span = document.createElement("span");
            span.textContent = time;
            a.href = "#";
            a.onclick = function() {
            return false;
            };
            a.appendChild(span);
            li.appendChild(a);
            timeList.appendChild(li);

            // 각 <a> 요소에 이벤트 리스너 추가
            a.addEventListener("click", function() {
                // 선택되지 않은 요소에 대한 적용 내용(1)(클래스명 삭제)
                document.querySelectorAll("#timeList li a").forEach(function(item) {
                item.classList.remove("selected");
                });
    
                // 선택된 요소에 대한 적용 내용(클래스명 추가, 배경색상 변경)
                a.classList.add("selected");
                a.style.backgroundColor = "yellow";
    
                // 선택되지 않은 요소에 대한 적용 내용(2)(배경색상 투명)
                document.querySelectorAll("#timeList li a:not(.selected)").forEach(function(item) {
                item.style.backgroundColor = "transparent";
                });
            });
        });
    })
    .catch(error => console.error(error));
}

// 영화와 날짜를 선택할 때마다 getTimeList 함수를 호출하여 상영 시간 정보를 업데이트함
document.querySelectorAll(".movie-list li a").forEach(movie => {
movie.addEventListener("click", getTimeList);
});

document.querySelectorAll("#dateList li a").forEach(date => {
date.addEventListener("click", getTimeList);
});
  
