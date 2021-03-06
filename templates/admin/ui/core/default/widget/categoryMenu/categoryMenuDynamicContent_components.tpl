
{**********************************************************************
* ModuleFramework product developed. (2017-09-18)
* *
*
*  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
*  CONTACT                        ->       contact@modulesgarden.com
*
*
* This software is furnished under a license and may be used and copied
* only  in  accordance  with  the  terms  of such  license and with the
* inclusion of the above copyright notice.  This software  or any other
* copies thereof may not be provided or otherwise made available to any
* other person.  No title to and  ownership of the  software is  hereby
* transferred.
*
*
**********************************************************************}

{**
* @author Sławomir Miśkowicz <slawomir@modulesgarden.com>
*}

<script type="text/x-template" id="mg-category-menu">
    <div class="block">
        <div class="block__sidebar">

            <div class="widget" name="mgCategoryMenu" namespace="{$namespace}" index="{$rawObject->getIndex()}" id="{$elementId}">
                <div class="widget__header">
                    <div class="widget__top top">
                        <div class="top__title">
                            {if $rawObject->getIcon()}<i class="{$rawObject->getIcon()}"></i>{/if}
                            {$MGLANG->T('title')}
                        </div>
                        <div class="top__toolbar">
                            {$rawObject->insertButton('addCategoryButton')}
                            {$rawObject->insertHiddenSearchForm()}
                        </div>
                    </div>
                </div>
                {literal}
                <div class="widget__body">
                    <div class="preloader-container preloader-container--full-screen preloader-container--overlay" v-show="menuLoading">
                        <div class="preloader preloader--sm"></div>
                    </div>
                    <ul class="nav nav--tabs nav--border-left {/literal}{if $rawObject->isvSortable()}vSortable{/if}{literal}" id="groupList">
                        <li v-for="(dataRow, index) in returnedData" :class="{ 'sortable-disabled' : dataRow.id == 0, 'nav__item' : true, 'is-active': index === 0 }" :actionid="dataRow.id" :id="dataRow.elId">
                            <a href="javascript:;" class="nav__link" v-on:click="reloadMenuContent(dataRow.elId, dataRow.namespace, dataRow.id)" >
                                {/literal}{if $rawObject->isvSortable()} <span class="drag-and-drop-icon"><i class="zmdi zmdi-unfold-more"></i></span> {/if}{literal}
                                #{{ dataRow.id }} - {{ dataRow.title }}<span v-if="dataRow.count >= 0" class="badge badge--outline">{{ dataRow.count }}</span>
                                <span class="promoted-star-span" v-if="dataRow.suggested === 'on'">
                                    <i class="zmdi zmdi-star promoted-star"></i>
                                </span>
                            </a>
                            <ul class="nav nav--sub" v-if="dataRow.children && dataRow.children.length > 0">
                                <li v-for="(child, index) in dataRow.children" :class="{ 'nav__item' : true }" :actionid="child.id" :id="child.elId">
                                    <a href="javascript:;" class="nav__link" v-on:click="reloadMenuContent(child.elId, child.namespace, child.id)" >
                                        {/literal}{if $rawObject->isvSortable()} <span class="drag-and-drop-icon"><i class="zmdi zmdi-unfold-more"></i></span> {/if}{literal}
                                        #{{ child.id }} - {{ child.title }}
                                        <span class="promoted-star-span" v-if="child.suggested === 'on'">
                                            <i class="zmdi zmdi-star promoted-star"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>    
                </div>
            </div>
        </div>
        <div class="block__body" id="itemContentContainer">
            <component :is="contentContainerName"></component>
        </div>
        <div id="mg-templateContainer"></div>
    </div>
</script>                                    
                                    
<template id="mg-emptyBodyContainer">
    <div class="content-overlay" style="min-height: 200px;">
        <div class="lu-widget">
            <div class="lu-widget__body" style="min-height: 200px;">
                <div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay" v-show="contentLoading">
                    <div class="lu-preloader preloader--sm"></div>
                </div>
            </div>
        </div>            
    </div>
</template>                                    
{/literal}
