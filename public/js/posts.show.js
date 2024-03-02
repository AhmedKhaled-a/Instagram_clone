const token = document.querySelector(`meta[name=csrf-token]`).getAttribute('content');
console.log(token);
    
    // Event listener for delete comment buttons
    let deleteBtns = document.querySelectorAll('.comment-delete-button');
    if(deleteBtns) {
            deleteBtns.forEach( button => {
            button.addEventListener('click', commentDelete);
        });
    }

    function commentDelete(event) {
        let button = event.target;
        let commentId = this.getAttribute('data-comment-id');
        // SEND ajax request to delete comment
        $.ajax({
            type: "DELETE",
            url: `/api/posts/${commentId}/comments`,
            dataType: 'JSON',
            contentType: "application/json",
            cache: false,
            processData: false,
            headers: {'X-CSRF-TOKEN': token},
            success: function() {
                console.log("Done");
            }
        });  

        // delete the comment

        let commentCont = button.closest('.comment');
        commentCont.remove();

    }

let postBtn = document.getElementById('postButton');

console.log(postBtn);

postBtn.addEventListener('click', postComment);

function postComment(event) {
    console.log("starting click event listener");
    let commentInput = document.getElementById("comment_body");

    let username = document.getElementById('username').innerText;
    // console.log(username);


    let postId = event.target.getAttribute('data-post-id');

    console.log(postId);

    let button = document.createElement('button');
    button.className = "comment-delete-button";
    button.innerHTML = '<i class="fa-solid fa-trash-can text-danger fs-5"></i>';
    button.addEventListener('click' , commentDelete);

    $.ajax({
        type: "POST",
        url: `/api/posts/${postId}/comments`,
        dataType: 'JSON',
        contentType: "application/json",
        cache: false,
        processData: false,
        headers: {'X-CSRF-TOKEN': token},
        data : JSON.stringify({'comment_body' : commentInput.value}),
        success: function(res) {
            button.setAttribute('data-comment-id' , res.id);
        }
    });

    let img_path = 'http://localhost:8000/avatar/avatar.jpg';

    let cont = document.createElement('div');
    cont.className = "comment";

    let innerCont = document.createElement('div');
    innerCont.className = "d-flex mb-3";
    innerCont.innerHTML = `
            <img src="${img_path}" alt="" class='w-10 rounded-circle'>
            <a href="" class="text-dark text-decoration-none text-lg">${username}</a>
    `;

    let secondInnerCont = document.createElement('div');
    secondInnerCont.className = "d-flex justify-content-between";
    secondInnerCont.innerHTML =  `<div>
        <p>${commentInput.value}</p>
        <small>just now</small>
        </div>`;
    let buttonCont = document.createElement('div');
    buttonCont.insertAdjacentElement('afterbegin' , button);

    secondInnerCont.insertAdjacentElement('beforeend' , buttonCont);
    cont.insertAdjacentElement('afterbegin' , innerCont);
    cont.insertAdjacentElement('beforeend' , secondInnerCont);

    let commentsContainer = document.getElementById('commentContainer');
    commentsContainer.insertAdjacentElement('afterbegin' , cont);
    commentsContainer.scrollTo({ top: 0, behavior: 'smooth' });
    commentInput.value = '';
}

// document.getElementById('showMoreCommentsButton').addEventListener('click' , function(e) {
//     document.querySelectorAll('.remaining-comments .comment').forEach(comment => {
//         document.querySelector('.comments-container').appendChild(comment);
//     });

//     e.target.style.display = 'none';
// });
