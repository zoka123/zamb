<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>

    <title>{{{$title or ''}}}</title>

    <meta name="keywords" content="{{{ $meta_keywords or '' }}}"/>
    <meta name="author" content="{{{ $author or '' }}}"/>
    <meta name="description" content="{{{ $meta_description  or ''}}}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @section('stylesheets')
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.css">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,700,800&subset=latin,latin-ext'
              rel='stylesheet' type='text/css'>
        <link href='//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css' rel='stylesheet'
              type='text/css'>
        <link rel="stylesheet"
              href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>


        <link rel="stylesheet" href="{{asset('assets/css/select2-bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/site-theme.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/site-style.css')}}">
        <link rel="stylesheet" href="{{asset('packages/zantolov/zamb-ecommerce/assets/css/ecommerce.css')}}">


    @show


</head>

<body>
<div class="global-notifications text-center">
    @if (Session::get('error'))
        <div class="alert alert-danger">{{{ Session::get('error') }}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (Session::get('notice'))
        <div class="alert alert-success">{{{ Session::get('notice') }}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>

@yield('content')

@section('scripts')
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script type="text/javascript" language="javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" language="javascript"
            src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>

    <script type="text/javascript" language="javascript" src="{{asset('assets/js/site/site-application.js')}}"></script>

    <script type="text/javascript" language="javascript"
            src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.js"></script>


    <script>
        var homeUrl = "{{ Url::route('Site.Home') }}";
        var usernameCheckUrl = "{{ Url::route('Api.CheckUsername') }}";
        var emailCheckUrl = "{{ Url::route('Api.CheckEmail') }}";
        var getHtmlCartUrl = "{{ Url::route('Api.HtmlCart') }}";
        var getHtmlCartTableUrl = "{{ Url::route('Api.HtmlCartTable') }}";
        var removeCartItemUrl = "{{ Url::route('Api.RemoveCartItem') }}";
        var searchProductUrl = "{{ Url::route('Api.SearchProducts') }}";
        var updateCustomAddressUrl = "{{ Url::route('Shopper.Api.SetCustomAddress') }}";

        $(function () {
            $(".fancybox").fancybox({
                openEffect: 'none',
                closeEffect: 'none'
            });

            $('.dropdown-toggle').dropdown()


            @section('document-ready')
            // Inherited
            @show

        })
    </script>

@show

</body>
</html>
