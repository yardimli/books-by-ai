<style>
    .spine {
        width: 480px;
        height: 24px;
        background-color: #993333; /* Adjust per spine version */
        position: relative;
        overflow: hidden;
    }

    .spine-text {
        position: relative;
        display: flex;
        align-items: center;
        height: 100%;
        padding: 0 20px; /* Space for logo */
    }

    .spine-author-name {
        font-size: 12px;
        color: #FFFFDD; /* Adjust per spine version */
        margin-right: 20px;
        white-space: nowrap;
        overflow: hidden;
		    line-height: 24px;
    }

    .spine-title {
        font-size: 12px;
        color: #DDEE99; /* Adjust per spine version */
        white-space: nowrap;
        overflow: hidden;
		    line-height: 24px;
    }

    .uppercase-spine-title {
        font-size: 12px;
        color: #DDEE99; /* Adjust per spine version */
        text-transform: uppercase;
        white-space: nowrap;
        overflow: hidden;
    }

    .uppercase-spine-title-first-letter {
        font-size: 13px;
    }

    .spine-logo {
        position: absolute;
        right: 2px;
        top: 0px;
        height: 20px;
    }

    .spin-logo-img {
        height: auto;
        width: 20px;
		    transform: rotate(90deg);
    }
</style>

<div class="spine">
	<div class="spine-text">
		<span class="spine-author-name book-spine-author-name eb-garamond-regular"></span>
		<span class="uppercase-spine-title book-spine-title eb-garamond-regular"></span>
	</div>
	<div class="spine-logo">
		<img src="{{ asset('images/logo.png') }}" alt="Logo" class="spin-logo-img">
	</div>
</div>z
