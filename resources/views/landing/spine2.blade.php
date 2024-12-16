<style>
    .spine {
        width: 34px;
        height: 480px;
        background-color: black;
        position: relative;
    }

    .spine-author-name {
        position: absolute;
        top: 30px;
        left: 34px;
        padding: 0px;
        margin: 0px;
        transform-origin: left top;
        white-space: nowrap;
        width: 440px; /* Set to spine height */
        height: 34px; /* Set to spine width */
        rotate: 90deg;
        text-align: left;
        line-height: 34px;
        font-size: 1.1em;
        font-family: serif;
        color: #FFFFDD;
    }

    .spine-title {
        position: absolute;
        top: 0px;
        left: 34px;
        padding: 0px;
        margin: 0px;
        transform-origin: left top;
        white-space: nowrap;
        width: 300px; /* Set to spine height */
        height: 34px; /* Set to spine width */
        rotate: 90deg;
        text-align: right;
        line-height: 34px;
        font-size: 1.1em;
        font-family: serif;
        color: #DDEE99;
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
	<div class="spine-title"></div>
	<div class="spine-author-name"></div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
