const BASE_URL = "http://localhost:8000";

const token = document.querySelector("form > input[name='_token']").value;
console.log(token);


async function cfetch(url, options) {
    await fetch(BASE_URL + url, options)
    .then((res) => {
        res.json()
        .then((data) => {
            return data;
        });  
    })
}

async function toggleLike(icon) {
    icon.classList.toggle('fa-regular');
    icon.classList.toggle('fa-solid');
    let postId = icon.getAttribute("id");
    
    cfetch(`/api/posts/likes/${postId}`, {method: 'POST'
    ,headers: {
      "X-CSRF-Token": token,
    },  
  });
  setLikes(postId);
}

async function setLikes(postId) {
  // get likes
  await fetch(`${BASE_URL}/api/posts/likes/${postId}`, {method: 'GET', 
  headers: {
    "X-CSRF-Token": token,
  },  
})
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