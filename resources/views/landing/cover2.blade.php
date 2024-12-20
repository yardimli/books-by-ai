<style>
    .book-cover {
        width: 320px;
        height: 480px;
        background-color: #0c0c0c;
        position: relative;
        overflow: hidden;
    }

    .bestseller-badge {
        position: absolute;
        top: 50px;
        right: 15px;
        width: 75px;
        height: 75px;
        transform: rotate(15deg);
        z-index: 3;
    }


    .author-name {
        color: #FFFFDD;
        font-size: 1.5rem;
        text-align: center;
        padding: 20px;
        width: 100%;
        z-index: 2;
    }

    .author-image-container {
        position: absolute;
        top: 90px;
        left: 0px;
        width: 320px;
        height: 235px;
		    overflow: hidden;
    }

    .author-image {
		    position: absolute;
        width: 100%;
        object-fit: cover;
        display: block;
    }

    .title-subtitle-container {
        background-color: #0c0c0c;
        position: absolute;
        bottom: 0%;
        height: 160px;
        width: 320px;
        z-index: 2;
        padding: 5px 20px 20px 20px;
    }

    .title {
        color: #66FF00;
        font-size: 2.2rem;
        line-height: 1.1;
        text-align: left;
        letter-spacing: 2px;
        z-index: 2;
    }

    .subtitle {
        color: #FFFFDD;
        width: 80%;
        font-size: 0.6rem;
        text-align: left;
        line-height: 1.4;
    }
</style>

<div class="book-cover">
	<div class="bestseller-badge">
		<img class="badge-img" src="/cover-images/sticker2.png" alt="Bestseller Badge">
	</div>
	<div class="author-name roboto-mono-regular">LaLa La</div>
	
	<div class="author-image-container">
		<img class="author-image" src="path-to-author-image.jpg" alt="Author at typewriter">
	</div>
	<div class="title-subtitle-container">
		<div class="title bungee-tint-regular">REALTY GONE ROGUE!</div>
		<div class="subtitle roboto-mono-regular">Chronicles of Mischief with Mick and Lara in the Home-Buying World</div>
	</div>
</div>
