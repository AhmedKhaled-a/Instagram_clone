let followersListContainer = document.querySelector('.followers-container');

let followingsListContainer = document.querySelector('.followings-container');

let blockedListContainer = document.querySelector('.blocked-container');

let followersList = document.querySelector('.followers-container .followers-list');

let followingsList = document.querySelector('.followings-container .followings-list');

let blockedList = document.querySelector('.blocked-container .blocked-list');

let followers = document.querySelector('.followers');

let followings = document.querySelector('.followings');

let blocked = document.querySelector('.blocked');

followersListContainer.addEventListener('click', function(e){
    followersListContainer.classList.add("d-none");
})

followingsListContainer.addEventListener('click', function(e){
    followingsListContainer.classList.add("d-none");
})

blockedListContainer.addEventListener('click', function(e){
    blockedListContainer.classList.add("d-none");
})

followersList.addEventListener('click', (e) => {
    e.stopPropagation()
})

followingsList.addEventListener('click', (e) => {
    e.stopPropagation()
})

blockedList.addEventListener('click', (e) => {
    e.stopPropagation()
})

followers.addEventListener('click', (e) => {
    followersListContainer.classList.remove("d-none");
})

followings.addEventListener('click', (e) => {
    followingsListContainer.classList.remove("d-none");
})

blocked.addEventListener('click', (e) => {
    blockedListContainer.classList.remove("d-none");
})
