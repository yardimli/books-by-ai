<style>
    .book-cover {
        width: 320px;
        height: 480px;
        background-color: #000000;
        position: relative;
        font-family: monospace;
        overflow: hidden;
    }

    .bestseller-badge {
        position: absolute;
        top: 80px;
        right: 40px;
        background-color: #66FF00;
        padding: 20px;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transform: rotate(15deg);
        z-index: 1;
    }

    .badge-text {
        font-size: 0.6em;
        text-align: center;
        line-height: 1.2;
    }

    .author-name {
        color: white;
        font-size: 2em;
        text-align: center;
        top: 5%;
        width: 100%;
        z-index: 2;
        position: absolute;
    }

    .author-image {
        position: absolute;
        top: 25%;
        width: 100%;
        max-width: 300px;
        margin-left: 0px;
        margin-right: 0px;
        display: block;
    }

    .title {
        position: absolute;
        top: 65%;
        width: 100%;
        color: #66FF00;
        font-size: 2.5em;
        line-height: 1.1;
        text-align: center;
        padding: 20px;
        font-weight: bold;
        letter-spacing: 2px;
        z-index: 2;
    }

    .subtitle {
        position: absolute;
        bottom: 20px;
        width: 100%;
        color: white;
        font-size: 0.8em;
        text-align: center;
        padding-left: 20px;
        padding-right: 20px;
        margin: 0 auto;
        line-height: 1.4;
    }
</style>

<div class="book-cover">
	<div class="bestseller-badge">
		<div class="badge-text">
			<strong>#1</strong><br>
			WORLDWIDE<br>
			BESTSELLER
		</div>
	</div>
	
	<div class="author-name">LaLa La</div>
	
	<img class="author-image" src="path-to-author-image.jpg" alt="Author at typewriter">
	
	<div class="title">REALTY GONE ROGUE!</div>
	
	<div class="subtitle">Chronicles of Mischief with Mick and Lara in the Home-Buying World</div>
</div>
