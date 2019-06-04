<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row mb-5">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <div class="setting-container">
                                    <i class="la la-gear ks-icon"></i>
                                    <div class="setting-container-title">
                                        <h4>SETTINGS</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                        <ul>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="setting-container">
                                    <i class="la la-gear ks-icon"></i>
                                    <div class="setting-container-title">
                                        <h4>SETTINGS</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                        <ul>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <div class="setting-container">
                                    <i class="la la-gear ks-icon"></i>
                                    <div class="setting-container-title">
                                        <h4>SETTINGS</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                        <ul>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="setting-container">
                                    <i class="la la-gear ks-icon"></i>
                                    <div class="setting-container-title">
                                        <h4>SETTINGS</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                        <ul>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <div class="setting-container">
                                    <i class="la la-gear ks-icon"></i>
                                    <div class="setting-container-title">
                                        <h4>SETTINGS</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                        <ul>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="setting-container">
                                    <i class="la la-gear ks-icon"></i>
                                    <div class="setting-container-title">
                                        <h4>SETTINGS</h4>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                                        <ul>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                            <li><a href="#">Settings</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
		</page-content>
	</div>
</template>

<style scoped>
    .setting-container {
        display: flex;
    }

    .setting-container i {
        font-size: 63px;
        margin-right: 8px;
    }
    
    .setting-container h4 {
        color: #008240;
        margin-bottom: 4px;
    }

    .setting-container p {
        border-bottom: solid 1px #dedede;
        padding-bottom: 10px;
        font-size: 12px;
        margin-bottom: 9px;
    }

    .mb-3 {
        padding: 20px;
    }

    .setting-container-title ul{
        padding-left: 16px;
        color: #008240;
    }

    .setting-container-title li {
        margin-bottom: 4px;
    }

    .setting-container-title li a{
        color: #008240;
    }
</style>

<script>
	// components
	import PageHeader from '@components/page-header.vue'
    import PageContent from '@components/page-content.vue'

	export default {
		data() {
			return {
				title:'Settings',
				pageClass: 'ks-content-nav',
			}
		},
		components: {
			PageHeader,
			PageContent
		}
	}
</script>
