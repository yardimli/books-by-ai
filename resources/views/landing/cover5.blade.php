<style>
		.book-cover {
        width: 320px;
        height: 480px;
        background: url('/cover-images/light pink stripes_1425059.jpg');
        background-size: cover;
				position: relative;
    }

    .author-name {
        color: #333333;
        font-size: 2.0rem;
        text-align: center;
        padding: 20px;
        width: 100%;
        z-index: 2;
    }

    .author-image-container {
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        aspect-ratio: 4/5;
    }

    /* New inner container for the border */
    .author-image-border {
        position: absolute;
        top: -6px;
        left: -6px;
        width: calc(100% + 14px);
        height: calc(100% + 14px);
        border-radius: 50%;
        border: 0.5rem solid #ff92cb;
        z-index: 2;
    }

    /* Modified author image styles */
    .author-image-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        background-color: #f1f1f1;
    }

    .author-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    .title-subtitle-container {
        position: absolute;
        top: 67%;
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
        position: absolute;
        top: 65%;
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

    
</style>
</head>
<body>
<div class="book-cover">
	<div class="author-name birthstone-regular"></div>
	<div class="author-image-container">
		<div class="author-image-border"></div>
		<div class="author-image-wrapper">
			<img class="author-image" src="/author-images/author2.jpg">
		</div>
	</div>
	<div class="title-subtitle-container">
		<div class="title young-serif-regular">Realty Gone Rouge!</div>
		<div class="subtitle charis-sil-bold-italic">Chronicles of Mischief with Mick and Lara in the Home-Buying World</div>
	</div>
</div>
