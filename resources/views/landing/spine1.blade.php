<style>
    .spine {
        width: 24px;
        height: 480px;
        background-color: #993333;
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
		    font-size:12px;
        color: #FFFFDD;
		    margin-right: 20px;
        overflow: hidden;
        display: inline-block;
    }

    .spine-title {
        line-height: 24px;
        height: 24px;
        min-height: 24px;
        font-size: 12px;
        color: #DDEE99;
        overflow: hidden;
        display: inline-block;
    }

    .uppercase-spine-title {
        line-height: 24px;
        height: 24px;
        min-height: 24px;
        font-size: 12px;
        color: #DDEE99;
        text-transform: uppercase;
        overflow: hidden;
        display: inline-block;
    }

    .uppercase-spine-title-first-letter {
        font-size: 14px;
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
		<span class="spine-author-name book-spine-author-name eb-garamond-regular"></span>
		<span class="uppercase-spine-title book-spine-title eb-garamond-regular"></span>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
