
let likeBtns = document.getElementsByClassName("like-button");
console.log(likeBtns);
Array.from(likeBtns).forEach(likeBtn => {
    likeBtn.addEventListener("click" , toggleLike);
    
});
const BASE_URL = "http://localhost:8000";
const token = document.querySelector("form > input[name='_token']").value;


const token = document.querySelector("form > input[name='_token']").value;
console.log(token);


async function cfetch(url, options) {
    await fetch(BASE_URL + url, options)
    .then((res) => {
        res.json()
        .then((data) => {
            console.log(data);
        });  
    })
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
    cfetch(`/api/posts/${button.getAttribute("id")}`, {method: 'DELETE'});
    
    console.log(button.closest(".post"));
    button.closest(".post").remove();
}