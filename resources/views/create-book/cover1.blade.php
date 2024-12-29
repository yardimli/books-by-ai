<style>
    .book-cover {
        width: 320px;
        height: 480px;
        background: url('/cover-images/cover1.png');
        background-size: cover;
        position: relative;
    }

    .uppercase-title {
        padding-top: 30px;
		    padding-left: 20px;
		    padding-right: 20px;
		    padding-bottom: 20px;
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
        top: 170px;
        left: 80px;
        width: 160px;
        height: 220px;

        border-radius: 50%;
        overflow: hidden;
        background-color: #ead0b3;
        text-align: center;
    }
    
    .author-image {
        position: absolute;
        width: 100%;
        object-fit: cover;
        display: block;
    }

    .author-image-border {
        position: absolute;
        top: 160px;
        left: 70px;
        width: 180px;
        height: 240px;
        border-radius: 50%;
        border: 0.2rem solid #999933;
        z-index: 2;
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
	<div class="author-image-border"></div>
	<div class="author-image-container">
		<img class="author-image" src="/author-images/author2.jpg">
	</div>
	<div class="uppercase-author-name author-name eb-garamond-regular"></div>
</div>
