switchToChannel(1);
fetchAllChannels();

// clear les posts pour changer de channel
function switchToChannel(channelId) {
    currentChannelId = channelId;
    lastId = 0;

    document.getElementById('posts').innerHTML = '';
    getPosts();
}

// recup les channels
function fetchAllChannels() {
    fetch('api/getChannels.php',
        {
            method: 'GET'
        }
    )
    .then(response => response.json())
    .then(data => {
        for (i = 0 ; i < data.length ; i++) {
            name = data[i]['name'];
            id = data[i]['id'];

            document.getElementById('channels').insertAdjacentHTML('beforeend', '<div onmousedown="switchToChannel('+id+')">'+ name +'</div>');
        }
    });
}

// recup les posts depuis le dernier id (lastId)
function getPosts() {
    const data = { channel_id: currentChannelId, last_id: lastId };

    fetch('api/getPostsByChannel.php',
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }
    )
    .then(response => response.json())
    .then(data => {
        console.log(data);

        for (i = 0 ; i < data.length ; i++) {
            body = data[i]['body'];
            author = data[i]['author'];
            lastId = data[i]['id'];

            document.getElementById('posts').insertAdjacentHTML('beforeend', '<div><span class="name">'+ author +'</span> : '+ body +'</div>');
        }
    });
}


// ajout d'un post
document.getElementById('newPost').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(e.target);

    const data = { body: formData.get('body'), author: formData.get('author'), channel_id: currentChannelId };

    fetch('api/addPost.php',
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        }
    ).then(function() {
        getPosts();
    });
});
