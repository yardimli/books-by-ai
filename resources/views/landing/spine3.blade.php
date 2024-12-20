<style>
    .spine {
        width: 24px;
        height: 480px;
        background-color: black;
        position: relative;
        overflow: hidden;
    }

    .spine-text {
        position: absolute;
        top: 20px;
        left: 24px;
        padding: 0px;
        margin: 0px;
        transform-origin: left top;
        white-space: nowrap;
        width: 440px; /* Set to spine height */
        height: 24px; /* Set to spine width */
        transform: rotate(90deg);
        overflow: hidden;
    }

    .spine-author-name {
        line-height: 24px;
        height: 24px;
        min-height: 24px;
        font-size: 10px;
        color: #fafafa;
        margin-right: 20px;
        overflow: hidden;
        display: inline-block;
    }

    .spine-title {
        line-height: 24px;
        height: 24px;
        min-height: 24px;
        font-size: 12px;
        color: #fafafa;
        overflow: hidden;
        display: inline-block;
    }

    .uppercase-spine-title {
        line-height: 24px;
        height: 24px;
        min-height: 24px;
        font-size: 1.1rem;
        color: #DDEE99;
        text-transform: uppercase;
        overflow: hidden;
        display: inline-block;
    }

    .uppercase-spine-title-first-letter {
        font-size: 1.3rem;
    }

    .spine-logo {
        position: absolute;
        bottom: 10px;
        left: 0px;
        width: 24px;
        text-align: center;
    }

    .spin-logo-img {
        width: 20px;
    }
</style>
</head>
<body>
<div class="spine">
	<div class="spine-text">
		<span class="spine-author-name book-spine-author-name cabin-regular"></span>
		<span class="spine-title book-spine-title cabin-bold"></span>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
