<style>
    .book-cover {
        width: 320px;
        height: 480px;
        background-color: #000000;
        position: relative;
        overflow: hidden;
    }

    .bestseller-badge {
        position: absolute;
        top: 40%;
        right: 5px;
        width: 70px;
        height: 70px;
		    rotate: 15deg;
        z-index: 3;
    }

    .badge-img {
        width: 100%;
        height: 100%;
    }
    
    .header-text {
        color: #66FF00;
        font-size: 0.7rem;
        text-align: center;
        padding: 10px 20px 0px;
        width: 100%;
        z-index: 2;
    }

    .author-name {
        color: #FFFFDD;
        font-size: 2.0rem;
        text-align: center;
        z-index: 2;
    }

    .author-image {
        position: absolute;
        top: 10%;
        left: 0px;
        width: 100% !important;
        max-width: 100%;
        display: block;
    }

    .cover-middle-image {
        position: absolute;
        top: 50%;
        height: 50%;
        width: 100%;
        z-index: 2;
    }
    
    .cover-middle-image-img {
				width: 100%;
				height: 100%;
				object-fit: cover;
		}

    .title-subtitle-container {
        position: absolute;
        bottom: 5%;
        width: 100%;
        z-index: 2;
    }

    .title {
        padding: 20px;
        text-align: center;
        color: #66FF00;
        font-size: 2.2rem;
        line-height: 1.1;
        text-align: left;
        letter-spacing: 2px;
        z-index: 2;
    }

    .uppercase-title {
        padding: 20px;
        text-align: center;
        font-size: 2.5rem;
        line-height: 1;
        color: #66FF00;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .uppercase-title-first-letter {
        color: #66FF00;
        font-size: 3rem;
    }

    .subtitle {
		    padding-left: 40px;
		    padding-right: 40px;
        color: #FFFFDD;
        font-size: 0.6rem;
        text-align: center;
        line-height: 1.4;
        text-transform: uppercase;
    }
</style>

<div class="book-cover">
	<div class="bestseller-badge">
		<img class="badge-img" src="/cover-images/sticker4.png" alt="Bestseller Badge">
	</div>
	<div class="header-text eb-garamond-bold">Sold Over 3 Million Copies Worldwide | "Changed My Life"</div>
	<div class="author-name eb-garamond-bold">LaLa La</div>
	
	<img class="author-image" src="path-to-author-image.jpg" alt="Author at typewriter">
	
	<div class="cover-middle-image">
		<img src="/cover-images/background-summer-blue-light-wall-studio-room-2024-09-30-19-34-42-utc.jpg" alt="Book Cover Image" class="cover-middle-image-img">
	</div>
	
	<div class="title-subtitle-container">
		<div class="uppercase-title book-title oswald-bold">REALTY GONE ROGUE!</div>
		<div class="subtitle oswald-semibold">Chronicles of Mischief with Mick and Lara in the Home-Buying World</div>
	</div>
</div>
