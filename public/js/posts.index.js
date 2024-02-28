// const token = document.querySelector(`meta[name=csrf-token]`).getAttribute('content');
const token = document.querySelector(`meta[name=csrf-token]`).getAttribute('content');


let likeBtns = document.getElementsByClassName("like-button");
console.log(likeBtns);
Array.from(likeBtns).forEach(likeBtn => {
    likeBtn.addEventListener("click" , toggleLike);
});

let bookMarkBtns = document.getElementsByClassName("bookmark-btn");
Array.from(bookMarkBtns).forEach(bookMarkBtn => {
  bookMarkBtn.addEventListener("click" , savePost);
});


let prevBtns = document.getElementsByClassName("previous");
Array.from(prevBtns).forEach(prevBtn => {
  prevBtn.addEventListener("click" , nextScroll);
});


let nextBtns = document.getElementsByClassName("next");
Array.from(nextBtns).forEach(nextBtn => {
  nextBtn.addEventListener("click" , nextScroll);
});

const BASE_URL = "http://localhost:8000";


async function cfetch(url, options) {
    await fetch(BASE_URL + url, options)
    .then((res) => {
        res.json()
        .then((data) => {
            console.log(data);
        });  
    });
}

async function toggleLike(event) {
    let userId = document.getElementById("userId").getAttribute("userId");
    console.log(userId);
    let icon = event.target;
    icon.classList.toggle('fa-regular');
    icon.classList.toggle('fa-solid');

    let postId = icon.getAttribute("id");
    var data = JSON.stringify({ "userId" : userId });
    $.ajax({
    type: "POST",
    url: `/api/posts/${postId}/togglelike`,
    dataType: 'JSON',
    contentType: "application/json",
    headers: {'X-CSRF-TOKEN': token},
    cache: false,
    processData: false,
    data: data,
    success: function() {
        console.log("Done");
    }
  })

    // get likes
    await fetch(`${BASE_URL}/api/posts/${postId}/likes`, {method: 'GET'})
    .then(function(res){ 
    res.json()
      .then(function(data) { 
        document.querySelector(`.likesCount-${ postId }`).innerText = data;
      })
      .catch(function(e){
        console.log(e);
      });
    })
    .catch(function(e){
      console.log(e);
  });    
}
 
function deletePost(button) {
    $.ajax({
      type: "DELETE",
      url: `/api/posts/${button.getAttribute("id")}`,
      dataType: 'JSON',
      contentType: "application/json",
      headers: {'X-CSRF-TOKEN': token},
      cache: false,
      processData: false,
      data: data,
      success: function() {
          console.log("Done");
      }
    });
    
    // console.log(button.closest(".post"));
    button.closest(".post").remove();
}

function savePost(e) {
    let icon = e.target;
    // console.log(e.target.closest("section"));
    let postId = e.target.closest("section").getAttribute("id");
    // console.log(postId);
    icon.classList.toggle('fa-regular');
    icon.classList.toggle('fa-solid');

    let userId = document.getElementById("userId").getAttribute("userId");
    let data = JSON.stringify({userId: userId, postId: postId});
    $.ajax({
        type: "POST",
        url: `/api/posts/save`,
        dataType: 'JSON',
        contentType: "application/json",
        cache: false,
        headers: {'X-CSRF-TOKEN': token},
        processData: false,
        data: data,
        success: function() {
            console.log("Done");
        }
    })
}

function prevScroll(e) {
  e.stopPropagation();
  let caro = e.target.parentElement.previousElementSibling;
  console.log(caro);
  if( caro != null)
    caro.scrollBy(-100, 0);
  // console.log();
}

function nextScroll(e) {
  e.stopPropagation();
  let caro = e.target.parentElement.previousElementSibling;
  console.log(caro);
  console.log(e.target.parentElement);
  if( caro != null)
    caro.scrollBy(100, 0);
  // console.log();
}