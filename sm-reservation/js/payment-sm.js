/* --------reservation-seatSelect.html에서 전달한 정보 받기-------- */
// 현재 URL에서 쿼리 문자열 가져오기
var queryString = window.location.search;

// 쿼리 문자열의 '?' 제거하기
queryString = queryString.substring(1);

// '&'를 기준으로 쿼리 매개변수 분할하기
var queryParameters = queryString.split('&');

// 분할된 쿼리 매개변수 반복하여 값 추출하기
var parameters = {};
for (var i = 0; i < queryParameters.length; i++) {
var parameter = queryParameters[i].split('=');
var paramName = decodeURIComponent(parameter[0]);
var paramValue = decodeURIComponent(parameter[1]);
parameters[paramName] = paramValue;
}

// 추출한 값 사용하기
var selMovie = parameters['selMovie'];
var selDate = parameters['selDate'];
var selTime = parameters['selTime'];
var selMovieId = parameters['selMovieId'];
var selSeat = parameters['selSeat'];
var count = parameters['count'];
var costs = parameters['costs'];



/* --------getImageSrc.php에서 ImageSrc받아오기-------- */
var requestUrl = `http://semin1127.dothome.co.kr/sm-reservation/php/getImageSrc.php?movieId=${selMovieId}`;
fetch(requestUrl)
.then(response => response.json())
.then(data => {
    console.log(data);
    console.log(data[0]);
    var img = document.getElementById('movieImg');
    img.setAttribute("src", "../../movie/poster/" + data[0]);
})



/* --------선택 정보 테이블 채우기-------- */
var title = document.getElementById('title');
var date = document.getElementById('date');
var time = document.getElementById('time');
var seat = document.getElementById('seat');
var cost = document.getElementById('cost');

var today = new Date();

title.innerText = selMovie;
date.innerText = today.getFullYear() + "-" + (today.getMonth()+1) + "-" + selDate;
time.innerText = selTime;
seat.innerText = selSeat;
cost.innerText = costs + '원';