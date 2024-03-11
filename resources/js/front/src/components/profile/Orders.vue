<template>
    <div class="content-heading-holder">
        <button type="button" class="mobile-back-btn"></button>
        <h1 class="content-heading">Pasūtījumu vēsture</h1>
    </div>

    <div class="orders-history">
        <div class="tabs-holder">
            <div class="tabs-nav">
                <button type="button" class="nav-item current">Visi</button>
                <button type="button" class="nav-item">Piegādāts</button>
                <button type="button" class="nav-item">Atcelts</button>
            </div>

            <div class="tab-content">
                <table class="table orders-table">
                    <thead>
                        <tr>
                            <th class="order-no">Pasūtījuma Nr.</th>
                            <th class="date">Datums</th>
                            <th class="client-name">Piegāde uz</th>
                            <th class="price">Kopā</th>
                            <th class="status">Statuss</th>
                            <th class="action">Darbība</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td data-mobile="Pasūtījuma Nr." class="order-no">0002255</td>
                            <td data-mobile="Datums" class="date">10/10/23</td>
                            <td data-mobile="Piegāde uz" class="client-name">Rolands Rautmanis</td>
                            <td data-mobile="Kopā" class="price">€1 295,00</td>
                            <td data-mobile="Statuss" class="status in-progress">Apstrādā</td>
                            <td data-mobile="Darbība" class="action"><span>Skatīt</span></td>
                        </tr>

                        <tr>
                            <td data-mobile="Pasūtījuma Nr." class="order-no">0002234</td>
                            <td data-mobile="Datums" class="date">09/09/23</td>
                            <td data-mobile="Piegāde uz" class="client-name">Rolands Rautmanis</td>
                            <td data-mobile="Kopā" class="price">€195,00</td>
                            <td data-mobile="Statuss" class="status delivered">Piegādāts</td>
                            <td data-mobile="Darbība" class="action"><span>Skatīt</span></td>
                        </tr>
                    </tbody>
                </table>  
            </div>
        </div>

        <div class="toolbar">
            <span class="amount">2 pasūtījumi</span>

            <div class="select-limit">
                <span>Rādīt</span>
                <div class="select-group opened">
                    <input type="text" name="" value="10" readonly>

                    <div class="dropdown">
                        <ul class="inner-dropdown">
                            <li>20</li>
                            <li>30</li>
                        </ul>
                    </div>
                </div>                
            </div>
        </div>

        <br>
        <br>
        <br>

        <h1 class="content-heading">Pasūtījuma detaļas</h1>

        <div class="order-view">
            <div class="order-details">
                <div class="short-details">
                    <ul>
                        <li>
                            <span class="label">Pasūtījuma nr.</span>
                            <span class="value">0002255</span>
                        </li>

                        <li>
                            <span class="label">Pasūtījuma datums</span>
                            <span class="value">22.09.2023</span>
                        </li>

                        <li>
                            <span class="label">Piegādes datums</span>
                            <span class="value">24.09.2023</span>
                        </li>
                    </ul>
                </div>

                <div class="delivery-details">
                    <div class="block">
                        <span class="block-name">Norēķinu adrese</span>

                        <ul>
                            <li>Rolands Rautmanis</li>
                            <li>Brīvības iela 12, Rīga,</li>
                            <li>LV-1010, Latvija</li>
                            <li>Tālrunis: +371 27454454</li>
                        </ul>
                    </div>

                    <div class="block">
                        <span class="block-name">Piegādes adrese</span>

                        <ul>
                            <li>Rolands Rautmanis</li>
                            <li>Brīvības gatve 234, Rīga</li>
                        </ul>
                    </div>
                </div>
            </div>

            <table class="table summary-table">
                <thead>
                    <tr>
                        <th class="product">Produkts</th>
                        <th class="price">Cena</th>
                        <th class="amount">Daudzums</th>
                        <th class="sum">Summa</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="product" data-mobile="">
                            <div class="product-details">
                                <div class="image">
                                    <img src="../../../../../../resources/front/images/order-history-product-image-1.jpg" alt="">
                                </div>

                                <div class="details">
                                    <h4 class="name">
                                        <a href="#">Bremžu uzliku komplekts TRW GDB1307</a>
                                    </h4>

                                    <p class="product-code">Preces kods: 45672</p>
                                </div>
                            </div>
                        </td>

                        <td class="price" data-mobile="Cena">€39.70</td>
                        <td class="amount" data-mobile="Daudzums">1x</td>
                        <td class="sum" data-mobile="KOPĀ"><strong>€39.70</strong></td>
                    </tr>

                    <tr>
                        <td class="product" data-mobile="">
                            <div class="product-details">
                                <div class="image">
                                    <img src="../../../../../../resources/front/images/order-history-product-image-1.jpg" alt="">
                                </div>

                                <div class="details">
                                    <h4 class="name">
                                        <a href="#">Bremžu diski FEBI BILSTEIN 26647</a>
                                    </h4>

                                    <p class="product-code">Preces kods: 713289</p>
                                </div>
                            </div>
                        </td>

                        <td class="price" data-mobile="Cena">€36.30</td>
                        <td class="amount" data-mobile="Daudzums">2x</td>
                        <td class="sum" data-mobile="KOPĀ"><strong>€72.60</strong></td>
                    </tr>

                    <tr>
                        <td class="product" data-mobile="">
                            <div class="product-details">
                                <div class="image">
                                    <img src="../../../../../../resources/front/images/order-history-product-image-1.jpg" alt="">
                                </div>

                                <div class="details">
                                    <h4 class="name">
                                        <a href="#">Suporta izspiedēja komplekts YATO YT-0611</a>
                                    </h4>

                                    <p class="product-code">Preces kods: 34328 </p>
                                </div>
                            </div>
                        </td>

                        <td class="price" data-mobile="Cena">€31.30</td>
                        <td class="amount" data-mobile="Daudzums">1x</td>
                        <td class="sum" data-mobile="KOPĀ"><strong>€31.30</strong></td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="1" class="payment">
                            <h5>Apmaksa</h5>
                            <p>Ar maksājumu karti preces saņemšanas brīdī</p>
                        </td>

                        <td colspan="3" class="summary">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Piegādes izmaksas</td>
                                        <td>€0.00</td>
                                    </tr>

                                    <tr>
                                        <td>Pasūtījuma summa</td>
                                        <td>€143.60</td>
                                    </tr>

                                    <tr class="total">
                                        <td>Kopā <span class="vat">iesk. PVN 21%</span></td>
                                        <td>€143.60</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="bottom-toolbar">
                <button type="button" class="back-link">Atpakaļ</button>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'profileOrders',
    props: ['locale'],
    data() {
        return {
            viewLoaded: false
        }
    },
    mounted() {}
}
</script>

<style lang="scss" scoped>
    .content-heading {
        margin: 0 0 32px 0;
        font-size: 28px;
        line-height: 34px;
        letter-spacing: -0.56px;

        @media screen {
            @media (max-width: 991px) {
                font-size: 23px;
                line-height: 29px;
                letter-spacing: -0.46px;
            }
        }

        &.tablet-hidden {
            @media screen {
                @media (max-width: 991px) {
                    display: none;
                }
            }
        }
    }

    .select-limit {
        display: flex;
        align-items: center;
        gap: 0 8px;

        > span {
            line-height: 14px;
            font-size: 14px;
        }
    }

    .select-group {
	    position: relative;
        width: 72px;

		> input {
			height: 34px;
            width: 100%;
		    padding: 0 30px 0 12px;
			background: transparent url('../../../../../../resources/front/images/select-arrow-down.svg') calc(100% - 12px) center no-repeat;
			border: 1px solid #D8DADE;
			font-size: 14px;
			color: #0D2441;
			cursor: pointer;
			border-radius: 8px;

			&:focus {
				background: url('../../../../../../resources/front/images/input-arrow-rotated.svg') calc(100% - 13px) center no-repeat;
			}
		}

		.dropdown {
			display: none;
			position: absolute;
			top: calc(100% + 4px);
			left: 0;
			right: 0;
			max-height: 220px;
			padding: 8px 0;
			background-color: #FAFAFA;
			overflow: auto;
			box-shadow: 0px 1px 3px 0px rgba(49, 49, 49, 0.10);
			border-radius: 8px;
			z-index: 1;

			&::-webkit-scrollbar {
				width: 5px;
			}

            &::-webkit-scrollbar-track {
				background: #E9EAEC;
				border-radius: 3px;
			}

			&::-webkit-scrollbar-thumb {
				background: #C7C7C7;
				border-radius: 3px;
			}

			&::-webkit-scrollbar-thumb:hover {
				background: #B3B6BD;
			}

			.inner-dropdown {
				li {
					padding: 10px 16px;
					font-size: 14px;
					line-height: 14px;
					color: #0D2441;
					cursor: pointer;
					transition: all .3s ease-in-out;

					&.active, &:hover {
						background: #E3E5E8;
                    }
    		    }
            }
        }

        &.opened {
            > input {
				background: transparent url('../../../../../../resources/front/images/toolbar-select-arrow-opened.svg') calc(100% - 12px) center no-repeat;
			}

			.dropdown {
                display: block;
			    visibility: visible;
				opacity: 1;
			}
        }
    }

    .orders-history {
        padding: 15px 0 0 0;

        .tabs-holder {
            .tabs-nav {
                display: flex;
                gap: 0 16px;
                margin-bottom: 31px;
                border-bottom: 1px solid #E3E5E8;

                @media screen {
                    @media (max-width: 575px) {
                        margin-bottom: 8px;
                    }
                }

                .nav-item {
                    padding: 4px 12px 8px 12px;
                    margin-bottom: -1px;
                    border-bottom: 3px solid transparent;
                    line-height: 16px;
                    font-size: 16px;
                    color: #49515A;
                    transition: all 0.3s ease;
                    cursor: pointer;

                    &:hover {
                        color: #E72E2C;
                    }

                    &.current {
                        border-color: #E72E2C;
                        color: #E72E2C;
                        font-weight: 600;
                    }

                    @media screen {
                        @media (max-width: 575px) {
                            flex-basis: 33.33%;
                            padding-bottom: 5px;
                            line-height: 14px;
                            font-size: 14px;
                        }
                    }
                }
            }
        }
                                    
        .table {
            width: 100%;
            border-collapse: collapse;

            td, th {
                border-color: inherit;
                border-style: solid;
                border-width: 0;
                vertical-align: middle;
                text-align: left;

                @media screen {
                    @media (min-width: 992px) { 
                        border-bottom: 1px solid #E9EAEC;
                        
                        &:first-child {
                            padding-left: 17px;
                        }

                        &:last-child {
                            padding-right: 17px;
                            text-align: right;
                        }                        
                    }
                }
            }

            thead {
                tr {
                    th {
                        font-weight: 600;
                        color: #0D2441;
                    }
                }
            }

            &.orders-table {
                margin-bottom: 24px;

                thead {
                    @media screen {
                        @media (max-width: 991px) {
                            display: none;
                        }
                    }

                    tr {
                        th {
                            padding-bottom: 17px;
                            line-height: 12px;
                            font-size: 12px;
                            text-transform: uppercase;

                            &.order-no {
                                width: 22.47%;
                            }

                            &.date {
                                width: 15.35%;
                            }
                            &.client-name {
                                width: 22.47%;
                            }
                            &.price {
                                width: 70px;
                            }
                            &.status {
                                width: 15.35%;
                                text-align: right;
                            }

                            &.action {
                            }
                        }
                    }
                }

                tbody {
                    > tr {
                        > td {
                            padding-top: 14px;
                            padding-bottom: 14px;
                            font-size: 14px;

                            &.in-progress {
                                color: #FF7E36;
                            }

                            &.delivered {
                                color: #49A041;
                            }

                            @media screen {
                                @media (min-width: 992px) {
                                    background-color: #F4F4F6;
                                    
                                    &.order-no {
                                        width: 22.47%;
                                    }

                                    &.date {
                                        width: 15.35%;
                                    }
                                    &.client-name {
                                        width: 22.47%;
                                        padding-right: 10px;
                                    }
                                    &.price {
                                        width: 70px;
                                        white-space: nowrap;
                                        text-align: right;
                                    }
                                    &.status {
                                        width: 15.35%;
                                        text-align: right;
                                    }

                                    &.action {
                                        span {
                                            color: #E72E2C;
                                            cursor: pointer;
                                            text-decoration: underline;

                                            &:hover {
                                                text-decoration: none;
                                            }
                                        }
                                    }
                                }

                                @media (max-width: 991px) {
                                    position: relative;
                                    display: block;
                                    width: 100%;
                                    padding: 3.5px 0;
                                    border: 0;
                                    text-align: right;

                                    &::before {
                                        content: attr(data-mobile);
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        bottom: 0;
                                        height: 16px;
                                        margin: auto 0;
                                        line-height: 14px;
                                        font-size: 14px;
                                        font-weight: 600;
                                        color: #0D2441;
                                        text-align: left;
                                    }

                                    &.action {
                                        padding: 6px 0 22px 0;
                                        border-bottom: 1px solid #E9EAEC;
                                        text-align: center;

                                        span {
                                            font-size: 14px;
                                            font-weight: 400;
                                            color: #E72E2C;
                                            cursor: pointer;
                                        }

                                        &::before {
                                            content: normal;
                                        }
                                    }

                                    &:first-child {
                                        padding-top: 20px;

                                        &::before {
                                            top: auto;
                                            bottom: 7px;
                                        }
                                    }
                                }
                            }
                        }

                        @media screen {
                            @media (min-width: 992px) {
                                &:nth-child(2n+0) {
                                    td {
                                        background-color: #FFFFFF;
                                    }
                                }

                                &:last-child {
                                    td {
                                        border-bottom-width: 2px;
                                    }
                                
                                }
                            }
                        }
                    }
                }
            }        
        }

        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            .amount {
                line-height: 14px;
                font-size: 14px;
            }
        }

        .order-view {
            .order-details {
                margin: 0 0 51px 0;

                @media screen {
                    @media (max-width: 991px) {
                        margin: 0 0 31px 0;
                    }
                }

                .short-details {
                    padding: 24px;
                    background-color: #F4F4F6;
                    border-radius: 8px 8px 0 0;

                    @media screen {
                        @media (max-width: 991px) {
                            padding: 16px;
                        }
                    }

                    ul {
                        display: flex;
                        flex-direction: column;
                        gap: 16px 0;

                        @media screen {
                            @media (max-width: 991px) {
                                gap: 12px 0;
                            }
                        }


                        li {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            line-height: 16px;

                            @media screen {
                                @media (max-width: 991px) {
                                    font-size: 14px;
                                }
                            }

                            span {
                                &.label {
                                    font-weight: 500;
                                    color: #0D2441;
                                }

                                &.value {

                                }
                            }
                        }
                    }
                }

                .delivery-details {
                    display: flex;
                    padding: 24px;
                    border: 1px solid #E9EAEC;
                    border-top: 0;
                    border-radius: 0 0 8px 8px;

                    @media screen {
                        @media (max-width: 991px) {
                            flex-direction: column;
                            gap: 40px 0;
                            padding: 24px 16px;
                        }
                    }

                    .block {
                        flex-basis: 50%;
                        gap: 0 56px;

                        @media screen {
                            @media (max-width: 991px) {
                                flex-basis: 100%;
                                gap: 40px 0;
                            }
                        }

                        .block-name {
                            display: block;
                            margin: 0 0 16px 0;
                            line-height: 16px;
                            font-size: 16px;
                            font-weight: 500;
                            color: #0D2441;

                            @media screen {
                                @media (max-width: 991px) {
                                    margin: 0 0 12px 0;
                                }
                            }
                        }

                        ul {
                            li {
                                line-height: 24px;
                            }
                        }
                    }
                }
            }

            .table.summary-table {
                margin: 0 0 50px 0;

                thead {
                    @media screen {
                        @media (max-width: 991px) {
                            display: none;
                        }
                    }

                    tr {
                        th {
                            padding-bottom: 2px;

                            &.product {
                                width: 55.92%;
                            }

                            &.price {
                                width: 12.28%;
                            }

                            &.amount {
                                width: 19.73%;
                            }

                            &.price,
                            &.amount {
                                text-align: center;
                            }

                            &:first-child {
                                padding-left: 25px;
                            }

                            &:last-child {
                                padding-right: 25px;;
                            }

                            &:last-child {
                                text-align: right;
                            }
                        }
                    }
                }

                > tbody {
                    > tr {
                        > td {
                            padding-top: 20px;
                            padding-bottom: 20px;

                            .product-details {
                                display: flex;
                                align-items: center;
                                gap: 0 16px;

                                .image {
                                    flex-basis: 64px;
                                    flex-shrink: 0;
                                    flex-grow: 0;
                                }

                                .details {
                                    text-align: left;

                                    .name {
                                        margin: 0 0 4px 0;
                                        line-height: 18px;
                                        font-size: 16px;
                                        font-weight: 400;
                                        color: #0D2441;

                                        @media screen {
                                            @media (max-width: 991px) {
                                                line-height: 20px;
                                            }
                                        }
                                    }

                                    .product-code {
                                        margin: 0;
                                        line-height: 14px;
                                        font-size: 14px;
                                        color: #616571
                                    }
                                }
                            }

                            @media screen {
                                @media (min-width: 992px) {
                                    &.price,
                                    &.amount {
                                        text-align: center;
                                    }

                                    &:last-child {
                                        text-align: right;
                                    }

                                    &.product {
                                        width: 55.92%;
                                        padding-right: 10px;
                                    }

                                    &.price {
                                        width: 12.28%;
                                    }

                                    &.amount {
                                        width: 19.73%;
                                    }

                                    &:first-child {
                                        padding-left: 25px;
                                    }

                                    &:last-child {
                                        padding-right: 25px;;
                                    }
                                }
                            }

                            b, strong {
                                font-weight: 600;
                                color: #0D2441;
                            }

                            @media screen {
                                @media (max-width: 991px) {
                                    position: relative;
                                    display: block;
                                    width: 100%;
                                    padding: 2px 0;
                                    color: #7D8391;
                                    text-align: right;

                                    &::before {
                                        content: attr(data-mobile);
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        bottom: 0;
                                        height: 16px;
                                        margin: auto 0;
                                        line-height: 12px;
                                        font-size: 12px;
                                        font-weight: 500;
                                        color: #49515A;
                                        text-transform: uppercase;
                                        text-align: left;
                                    }

                                    &:first-child {
                                        padding-top: 24px;
                                    }

                                    &:last-child {
                                        padding-bottom: 19px;
                                        border-bottom: 1px solid #e9eaec;

                                        &::before {
                                            top: 9px;
                                            bottom: auto;
                                        }
                                    }
                                }
                            }
                        }

                        &:last-child {
                            td {
                                @media screen {
                                    @media (min-width: 992px) {
                                        border-bottom-width: 2px;
                                    }
                                }
                            }
                        }
                    }
                }

                tfoot {
                    td {
                        padding-top: 24px;
                        border: 0;
                        vertical-align: top;

                        &.payment {
                            padding-right: 30px;

                            h5 {
                                margin: 0 0 12px 0;
                                font-size: 16px;
                                font-weight: 500;
                                line-height: 16px;
                                color: #0D2441;

                                @media screen {
                                    @media (max-width: 991px) {
                                        margin: 0 0 5px 0;
                                    }
                                }
                            }

                            p {
                                color: #49515A;

                                &:last-child {
                                    margin: 0;
                                }
                            }
                        }

                        &.summary {
                            @media screen {
                                @media (max-width: 991px) {
                                    padding-top: 37px;
                                }
                            }

                            .table {
                                tbody {
                                    tr {
                                        td {
                                            padding: 2px 0;
                                            font-weight: 500;
                                            color: #0D2441;
                                            vertical-align: middle;

                                            @media screen {
                                                @media (max-width: 991px) {
                                                    &:last-child {
                                                        text-align: right;
                                                    }
                                                }
                                            }

                                            .vat {
                                                color: #7D8391;
                                                font-weight: 400;
                                                font-size: 14px;
                                            }
                                        }

                                        &.total {
                                            td {
                                                padding-top: 6px;
                                                line-height: 20px;
                                                font-size: 20px;
                                                font-weight: 600;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    > tr > td {
                        @media screen {
                            @media (max-width: 991px) {
                                display: block;
                                width: 100%;
                                padding-right: 0;
                                padding-left: 0;
                            }
                        }
                    }
                }
            }
        }
    }
</style>
