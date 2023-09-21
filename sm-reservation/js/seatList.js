/* --------index.html에서 전달한 정보 받기-------- */
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
var selMovie = parameters['movie'];
var selDate = parameters['date'];
var selTime = parameters['time'];
var selMovieId = parameters['movieId'];



/* --------좌석 목록 만들기-------- */
document.addEventListener('DOMContentLoaded', () => {
    var requestUrl = `http://semin1127.dothome.co.kr/sm-reservation/php/getSeat.php?selMovieId=${selMovieId}&selDate=${selDate}&selTime=${selTime}`;

    fetch(requestUrl)
        .then(response => response.json())
        .then(data => {
            var seatList = document.getElementsByClassName("seatList")[0];
            var seatCounts = 8;
            // A행부터 F행까지 총 6번 반복
            for (var i=0 ; i<(data.length/seatCounts) ; i++) {
                var rowChar = String.fromCharCode(65+i);
                var row = document.createElement("div");
                row.classList.add("row");
                row.classList.add(rowChar);

                var label = document.createElement("span");
                label.classList.add("label");
                label.textContent = rowChar;
                row.appendChild(label);

                // 1번 좌석부터 8번 좌석까지 8번 반복
                for (var j=0 ; j<seatCounts ; j++) {
                    var seat = document.createElement("span");

                    // 값이 1이면 예약된 자석
                    if (data[(i*seatCounts)+j] == 1) {
                        seat.classList.add("occupiedSeat");
                    } else {
                        seat.classList.add("seat");
                    }

                    seat.setAttribute("data-seat", rowChar + (j+1));
                    row.appendChild(seat);
                }

                seatList.appendChild(row);
            }
        })
        .catch(error => console.error(error));
})



/* --------좌석 선택에 대한 부분-------- */
var seatContainer = document.querySelector('.seatContainer');

var moviePrice = Number(8000); // 영화가격 

var count = document.querySelector('#count'); // 인원수
var costs = document.querySelector('#costs'); // 가격

// 선택한 좌석수 텍스트 변경해주기
function countSeatPrice() {
    const selectedSeatCount = document.querySelectorAll('.selectedSeat').length;

    count.textContent = selectedSeatCount;
    costs.textContent = (selectedSeatCount * moviePrice).toLocaleString();
}

// 좌석 클릭했을때 클래스 이름 변경해주기
seatContainer.addEventListener('click', (e) => {
    if(e.target.className === 'seat'){
        e.target.className = 'selectedSeat';
    } else if(e.target.className === 'selectedSeat'){
        e.target.className = 'seat';
    }

    countSeatPrice();
})