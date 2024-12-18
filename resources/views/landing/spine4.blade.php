<style>
    .spine {
        width: 34px;
        height: 480px;
        background-color: #0001bf;
        position: relative;
        overflow: hidden; /* Add this to contain child elements */
    }

    .spine-text {
        position: absolute;
        top: 20px;
        left: 34px;
        padding: 0px;
        margin: 0px;
        transform-origin: left top;
        white-space: nowrap;
        width: 440px; /* Set to spine height */
        height: 34px; /* Set to spine width */
        transform: rotate(90deg);
        overflow: hidden;
    }

    .spine-author-name {
        line-height: 34px;
        height: 34px;
        min-height: 34px;
        font-size: 0.9rem;
        color: #FFFFDD;
        margin-right: 20px;
        overflow: hidden;
        text-transform: uppercase;
        display: inline-block;
    }

    .spine-title {
        line-height: 34px;
        height: 34px;
        min-height: 34px;
        font-size: 1.1rem;
        color: #DDEE99;
        overflow: hidden;
        text-transform: uppercase;
        display: inline-block;
    }

    .uppercase-spine-title {
        line-height: 34px;
        height: 34px;
        font-size: 1.1rem;
        color: #DDEE99;
        overflow: hidden;
        text-transform: uppercase;
        display: inline-block;
    }

    .uppercase-spine-title-first-letter {
        font-size: 1.3rem;
    }

    .spine-logo {
        position: absolute;
        bottom: 10px;
        left: 0px;
        width: 34px;
        text-align: center;
    }

    .spin-logo-img {
        width: 30px;
    }
</style>
</head>
<body>
<div class="spine">
	<div class="spine-text">
		<div class="spine-author-name book-spine-author-name eb-garamond-bold"></div>
		<div class="spine-title book-spine-title oswald-semibold"></div>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
