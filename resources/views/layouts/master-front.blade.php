<!DOCTYPE html>
<html lang="en">
    @include('fronts.partials.head')
<body>

	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

	<!-- header -->
    @include('fronts.partials.navbar')
	<!-- end header -->

    {{-- Body --}}
    @yield('content')
    {{-- endBody --}}

	<!-- footer -->
    @include('fronts.partials.footer')
	<!-- end footer -->


{{-- script --}}
@include('fronts.partials.script')
{{-- endscirpt --}}

</body>
</html>
