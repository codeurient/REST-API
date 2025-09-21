let id = null;

async function getPosts() {
    let res = await fetch('http://localhost/REST-API/api/posts');
    let posts = await res.json();

    document.querySelector('.post-list').innerHTML = '';

    posts.forEach((post) => {
        document.querySelector('.post-list').innerHTML += `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">${post.title}</h5>
                    <p class="card-text">${post.body}</p>
                    <a style="cursor:pointer;" class="card-link text-danger"  onclick="deletePost(${post.id})">Delete post</a>

                    <a style="cursor:pointer;" class="card-link text-warning" onclick="selectPost('${post.id}',   '${post.title}',   '${post.body}')">Edit post</a>

                </div>
            </div>`;
    });
}

async function addPost() {
    const title = document.getElementById('title').value,
          body  = document.getElementById('body').value;

    let formData = new FormData();
    formData.append('title', title);
    formData.append('body',   body);

    const res = await fetch('http://localhost/REST-API/api/posts', {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.status === true) {
        await getPosts();
    }
}

async function deletePost(id) {
    const res = await fetch(`http://localhost/REST-API/api/posts/${id}`, {
        method: 'DELETE'
    });

    const data = await res.json();

    console.log("res: ", res);
    console.log("data: ", data);
    
    if (data.status === true) {
        await getPosts();
    }
}

function selectPost(postId, postTitle, postBody) {
    id = postId;
    document.getElementById('title-edit').value = postTitle;
    document.getElementById('body-edit').value = postBody;
}


async function updatePost() {
    const title = document.getElementById('title-edit').value,
          body  = document.getElementById('body-edit').value;
        
    const data = {
        title: title,
        body: body
    }

    const res = await fetch(`http://localhost/REST-API/api/posts/${id}`, {
        method: "PATCH",
        headers: {  "Content-Type": "application/json"  },
        body: JSON.stringify(data)
    })

    let resData = await res.json();

    if(resData.status === true) {
        await getPosts();
        id = null; // işi bitəndən sonra sıfırlamaq lazımdır. Əks halda UPDATE metodu birdəfə işlədikdən sonra xəta alarıq.
    }
}

// Səhifəyə görə avtomatik işə salsın
if (document.querySelector('.post-list')) {
    getPosts();
}