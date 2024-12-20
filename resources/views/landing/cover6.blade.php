<style>
		.book-cover {
        width: 320px;
        height: 480px;
        background-color: #f7d3b0;
				position: relative;
    }

    .title-subtitle-container {
		    padding-top: 40px;
        width: 100%;
        z-index: 2;
        padding-left: 20px;
        padding-right: 20px;
    }

    .title {
        color: #333333;
        font-size: 2.2rem;
        line-height: 1.1;
		    text-align: center;
        z-index: 2;
		    margin-bottom: 3px;
    }

    .uppercase-title {
        color: #333333;
        width: 100%;
        text-align: center;
        font-size: 2.0rem;
        line-height: 1;
        text-transform: uppercase;
    }

    .uppercase-title-first-letter {
        font-size: 2.2rem;
    }
    
    .subtitle {
        color: #333333;
        font-size: 0.8rem;
		    text-align: center;
    }

    .author-name {
		    margin-top: 20px;
        color: #333333;
        font-size: 2.0rem;
        text-align: center;
        top: 8%;
        width: 100%;
        z-index: 2;
    }

    .author-image-container {
        width: 210px;
        height: 210px;
        margin: 20px auto 0px;
        position: relative;

        border-radius: 5%;
        overflow: hidden;
        background-color: #f1f1f1;
        text-align: center;
    }

    .author-image {
        position: absolute;
        width: 100%;
        object-fit: cover;
        display: block;
    }
    
    .bestseller-badge {
        position: absolute;
        top: 40%;
        right: 20px;
        width: 80px;
        height: 80px;
        rotate: 15deg;
        z-index: 3;
    }
</style>
</head>
<body>
<div class="book-cover">
	<div class="bestseller-badge">
		<img class="badge-img" src="/cover-images/sticker6.png" alt="Bestseller Badge">
	</div>
	
	<div class="title-subtitle-container">
		<div class="title lato-black">Realty Gone Rouge!</div>
		<div class="subtitle lato-regular-italic">Chronicles of Mischief with Mick and Lara in the Home-Buying World</div>
	</div>
	<div class="author-image-container">
		<img class="author-image" src="/author-images/author2.jpg">
	</div>
	<div class="author-name oswald-regular"></div>

</div>
