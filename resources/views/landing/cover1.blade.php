<style>
    .book-cover-border {
        width: 314px; /* Slightly larger to accommodate inner div + margin */
        height: 474px;
        border-color: #999933;
        position: absolute;
        top: 3px;
		    left: 3px;
		    border-width: 0.2rem;
				border-style: solid;
    }

    .book-cover {
        width: 320px;
        height: 480px;
        background-color: #993333;
        position: relative;
    }

    .title {
        position: absolute;
        top: 5%;
        width: 100%;
        text-align: center;
        color: white;
        font-size: 2.5em;
        font-family: serif;
        line-height: 1.1;
		    color: #EEFFAA;
    }

    .subtitle {
        position: absolute;
        top: 25%;
        left: 20%;
        width: 60%;
        text-align: center;
        font-family: serif;
        font-size: 0.7em;
        color: #EEFFAA;
    }

    .author-image-container {
        position: absolute;
        top: 37%;
        left: 50%;
        transform: translateX(-50%);
        width: 55%;
        aspect-ratio: 4/5;
        position: relative; /* Added to handle absolute positioning of inner container */
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
		    background-color: #BBBB55;
    }

    .author-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-name {
        position: absolute;
        bottom: 5%;
        width: 100%;
        text-align: center;
        font-size: 1.2em;
        font-family: serif;
        color: #EEFFAA;
    }
</style>
</head>
<body>
<div class="book-cover">
	<div class="book-cover-border"></div>
	<div class="title"></div>
	<div class="subtitle"></div>
	<div class="author-image-container">
		<div class="author-image-border"></div>
		<div class="author-image-wrapper">
			<img class="author-image" src="/author-images/author2.jpg">
		</div>
	</div>
	<div class="author-name"></div>
</div>
