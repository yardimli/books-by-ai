<style>
    .book-cover {
        width: 320px;
        height: 480px;
        background: url('/cover-images/cover1.png');
        background-size: cover;
        position: relative;
    }

    .uppercase-title {
        padding: 20px;
        width: 100%;
        text-align: center;
        font-size: 2.0rem;
        line-height: 1;
        color: #F9F9F9;
        text-transform: uppercase;
    }

    .uppercase-title-first-letter {
        font-size: 2.2rem;
    }

    .subtitle {
		    padding-left: 40px;
		    padding-right: 40px;
        text-align: center;
        font-size: 0.7rem;
        color: #F9F9F9;
    }

    .author-image-container {
        position: absolute;
        top: 37%;
        left: 50%;
        transform: translateX(-50%);
        width: 55%;
        aspect-ratio: 4/5;
    }

    /* New inner container for the border */
    .author-image-border {
        position: absolute;
        top: -10px;
        left: -10px;
        width: calc(100% + 20px);
        height: calc(100% + 20px);
        border-radius: 50%;
        border: 0.2rem solid #999933;
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
        background-color: #ead0b3;
    }

    .author-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .uppercase-author-name {
        position: absolute;
        bottom: 20px;
        width: 100%;
        text-align: center;
        font-size: 1.1rem;
        color: #F9F9F9;
        text-transform: uppercase;
    }

    .uppercase-author-name-first-letter {
        font-size: 1.2rem;
    }

</style>
</head>
<body>
<div class="book-cover">
	<div class="title uppercase-title eb-garamond-bold"></div>
	<div class="subtitle eb-garamond-regular"></div>
	<div class="author-image-container">
		<div class="author-image-border"></div>
		<div class="author-image-wrapper">
			<img class="author-image" src="/author-images/author2.jpg">
		</div>
	</div>
	<div class="uppercase-author-name author-name eb-garamond-regular"></div>
</div>
