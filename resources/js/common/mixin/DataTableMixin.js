export default {
    data() {
        return {
            query: {
                filter: null,
                sorting: null,
                search: null,
                searchBy: null,
                pagination: {
                    currentPage: 1,
                    limit: 50       //limit is the same as perPage
                }
            },
            config: {
                pagination: {
                    lastPage: '',
                    currentPage: 1,
                    pages: 1,
                    total: 0,
                    perPage: 50,       //perPage is the same as limit
                    nextPageUrl: null,
                    prevPageUrl: null,
                    from: 0,
                    to: 0
                }
            }
        }
    },
    computed: {
        paginationFrom: function() {
            return (this.config.pagination.currentPage - 1) * this.config.pagination.perPage + 1;
        },
        paginationPages: function() {
            return Math.ceil(this.config.pagination.total / this.config.pagination.perPage);
        },
        paginationTo: function() {
            let to = this.config.pagination.from * this.config.pagination.perPage;

            return to <= this.config.pagination.total
                ? to
                : this.config.pagination.total;
        }
    },
    methods: {
        alternateBgColor: function(index) {
            return index % 2 == 0 ? 'even' : 'odd';
        },
        setPagination(data) {
            this.config.pagination.lastPage = data.last_page;
            this.config.pagination.currentPage = data.current_page;
            this.config.pagination.total = data.total;
            this.config.pagination.perPage = data.per_page;       //perPage is the same as limit
            this.config.pagination.nextPageUrl = data.links.next;
            this.config.pagination.prevPageUrl = data.links.previous;
            this.config.pagination.from = this.paginationFrom;
            this.config.pagination.to =this.paginationTo;
            this.config.pagination.pages = this.paginationPages;

            /**
             * Always set the current page to 1 when making queries.
             * This is to avoid rendering issue on the datatable and pagination.
             */
            this.query.pagination.currentPage = 1;
        },
        setFilter(filters) {
            this.query.filter = filters;
        },
        setSorting(orderBy) {
            this.query.sorting = orderBy;
        },
        setSearch(searches) {
            this.query.search = searches;
        },
        setSearchBy(searchBy) {
            this.query.searchBy = searchBy;
        },
        setPaginationLimit(limit) {        //limit is the same as perPage
            this.query.pagination.limit = limit;
            this.query.pagination.currentPage =
            (Math.ceil(this.config.pagination.total / limit) < this.query.pagination.currentPage) ?
                Math.ceil(this.config.pagination.total / limit):
                this.query.pagination.currentPage;
        },
        getParams() {
            let params = {
                take: this.query.pagination.limit,
                page: this.query.pagination.currentPage
            };

            // see if we have sorting
            if (this.query.sorting) {
                params['orderBy'] = this.query.sorting;
            }

            // see if we have filters
            if (this.query.filter) {
                params['filters'] = this.query.filter;
            }

            // see if we have searches
            if (this.query.search) {
                params['search'] = this.query.search;
            }

            // see if we have search by options
            if (this.query.searchBy) {
                params['searchBy'] = this.query.searchBy;
            }

            return params;
        },

        gotoPage(page) {
            if (page == 'prev') {
                // if previous page
                this.query.pagination.currentPage -= 1;
            } else if (page == 'next') {
                // if next page
                this.query.pagination.currentPage += 1;
            } else {
                // otherwise, go to page as specicifed
                this.query.pagination.currentPage = page;
            }
        },

        /**
         * Insert a div with width=100%, height with specified after the element that being represented by the selector
         * It's like, insert a new div that element (selector) with width=100% and height specified.
         * @param selector
         * @param height
         */
        async insertSpacer(selector,height,className='spacer'){
            let $ = jQuery;
            let $newDiv = $("<div>",{"class" : className});
            $newDiv.css({width: '100%', height: height});
            $(selector).after($newDiv);
        },

        async freezeElement(selector){
            let $ = jQuery;
            $(selector).css({position: 'fixed'});
        },

        async insertStyle(selector,css){
            $(selector).css(css);
        },

        enableFreezeFirstColumn(scroll_height_minimum,element_top_position){
            // Fixed the header during scroll to those page that uses data table.
            (function(){
                let $ = jQuery;
                let default_top_position = element_top_position;

                $.fn.createFixHeader = function(){
                    let window_width = $(window).width();
                    let top_position = default_top_position;
                    $("#fixedheader").remove();
                    $("table[class*='dataTable'] thead").clone().prependTo("table.dataTable");
                    let head1 = $("table[class*='dataTable'] thead:nth-child(1)");
                    let head2 = $("table[class*='dataTable'] thead:nth-child(2)");
                    head2.attr("id","fixedheader");

                    if(window_width<=1588){
                        top_position = default_top_position+34;
                    }if(window_width<=1423){
                        top_position = default_top_position;
                    }if(window_width<=1399){
                        top_position = default_top_position+34;
                    }if(window_width<=750){
                        top_position = default_top_position+54;
                    }if(window_width<=694){
                        top_position = default_top_position+88;
                    }

                    head2.css({
                        'position': 'fixed',
                        'background-color': 'white',
                        'width': ''+head1.width(),
                        'margin-top': '0px',
                        'top': top_position+'px',
                        'z-index': '1',
                        'border-bottom': '1px solid #DDD',
                        'display': 'none'
                    });

                    let x=1;
                    head2.find("tr th").each(function(){
                        head2.find("tr th:nth-child("+x+")").width(head1.find("tr th:nth-child("+x+")").width());
                        x++;
                    });
                }

                $.fn.duringScroll = function(){
                    let scroll = $(window).scrollTop(); //141
                    if(scroll >=scroll_height_minimum){ $("thead#fixedheader").show(); }
                    else{ $("thead#fixedheader").hide(); }
                }

                $(window).resize(function(){
                    console.log($(window).width(),"__WINDOW-WIDTH__");
                    $(this).createFixHeader();
                    $(this).duringScroll();
                });

                $(window).scroll(function() {
                    //console.log($(window).scrollTop(),"__SCROLL-TOP__");
                    $(this).duringScroll();
                });

                $(document).ready(function(){
                    $("table[class*='dataTable']").ready(function(){
                        setTimeout(function(){
                            $(this).createFixHeader();
                            $(this).duringScroll();
                        },500);
                    });
                });
            })();
        },

        enableFreezeHeaderOptions(scroll_height_minimum,element_top_position){
            // Fixed the header options during scroll to those page that uses data table.
            (function(){
                let $ = jQuery;
                let default_left = 307;

                $.fn.createFixHeaderOptions = function(){
                    let window_width = $(window).width();
                    let variable_left = default_left;
                    $("#fixedoptions").remove();
                    let parent = $(".ks-nav-body-wrapper > .container-fluid div.dataTables_wrapper");
                    $(".ks-nav-body-wrapper > .container-fluid div.dataTables_wrapper > div:nth-child(1)").clone().prependTo($(parent));
                    let head1 = $(".container-fluid div.dataTables_wrapper > div:nth-child(1)");
                    let head2 = $(".container-fluid div.dataTables_wrapper > div:nth-child(2)");
                    head2.attr("id","fixedoptions");

                    if(window_width<=1423){
                        //console.log("__HEADER-OPTION-LEFT-ADJUSTED__");
                        variable_left = default_left-189;
                    }if(window_width<=974){
                        //console.log("__HEADER-OPTION-LEFT-ADJUSTED__");
                        variable_left = default_left-261;
                    }

                    head2.css({
                        'position': 'fixed',
                        'background-color': '#FFF',
                        'width': ''+head1.width(),
                        'margin-top': '0px',
                        'top': element_top_position+'px',
                        'z-index': '1',
                        'border-top': '1px solid #DDD',
                        'border-bottom': '1px solid #DDD',
                        'display': 'none',
                        'left': variable_left+'px'
                    });
                }

                $.fn.duringScrollHeader = function(){
                    let scroll = $(window).scrollTop(); //141
                    if(scroll >=scroll_height_minimum){ $("#fixedoptions").show(); }
                    else{ $("#fixedoptions").hide(); }
                }

                $(window).resize(function(){
                    $(this).createFixHeaderOptions();
                    $(this).duringScrollHeader();
                });

                $(window).scroll(function() {
                    $(this).duringScrollHeader();
                });

                $(document).ready(function(){
                    $(".ks-nav-body-wrapper > .container-fluid div.dataTables_wrapper").ready(function(){
                        setTimeout(function(){
                            $(this).createFixHeaderOptions();
                            $(this).duringScrollHeader();
                        },500);
                    });
                });
            })();
        }
    }
}
