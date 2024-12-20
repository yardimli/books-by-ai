<style>
    .book-cover {
        width: 320px;
        height: 480px;
        background-color: #bababa;
        position: relative;
        overflow: hidden;
    }

    .bestseller-badge {
        position: absolute;
        top: 10%;
        right: 10px;
        width: 80px;
        height: 80px;
        z-index: 3;
    }

    .author-name {
		    position: relative;
        color:  #fafafa;
		    padding:20px;
        font-size: 2.0rem;
        z-index: 3;
    }

    .author-image-container {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 320px;
        height: 480px;
        overflow: hidden;
    }

    .author-image {
        position: absolute;
        width: 100%;
        object-fit: cover;
        display: block;
        filter: saturate(0);
    }
    
    .title-subtitle-container {
        position: absolute;
        bottom: 5%;
        width: 100%;
        z-index: 2;
        padding-left: 20px;
        padding-right: 20px;
    }

    .title {
        color: #fafafa;
        font-size: 2.5rem;
        line-height: 1.1;
        z-index: 2;
		    margin-bottom: 5px;
    }

    .subtitle {
		    width: 80%;
        color:  #fafafa;
        font-size: 0.75rem;
        line-height: 1.2;
    }
</style>

<div class="book-cover">
	<div class="bestseller-badge">
		<img class="badge-img" src="/cover-images/sticker3.png" alt="Bestseller Badge">
	</div>
	
	<div class="author-name cabin-regular">LaLa La</div>
	
	<div class="author-image-container">
		<img class="author-image" src="path-to-author-image.jpg" alt="Author at typewriter">
	</div>
	
	<div class="title-subtitle-container">
		<div class="title cabin-bold">REALTY GONE ROGUE!</div>
		<div class="subtitle cabin-regular">Chronicles of Mischief with Mick and Lara in the Home-Buying World</div>
	</div>
</div>
