<style>
    .spine {
        width: 34px;
        height: 480px;
        background-color: #993333;
        position: relative;
        overflow: hidden;
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
		    font-size: 1.1rem;
        color: #FFFFDD;
		    margin-right: 20px;
        overflow: hidden;
        display: inline-block;
    }

    .spine-title {
        line-height: 34px;
        height: 34px;
        min-height: 34px;
        font-size: 1.1rem;
        color: #DDEE99;
        overflow: hidden;
        display: inline-block;
    }

    .uppercase-spine-title {
        line-height: 34px;
        height: 34px;
        min-height: 34px;
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
		<span class="spine-author-name book-spine-author-name eb-garamond-regular"></span>
		<span class="uppercase-spine-title book-spine-title eb-garamond-regular"></span>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>
