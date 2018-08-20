@extends('frontend.layouts.app')

@section('title',  'Nepal Auto | Contact Us')

@section('keywords',  'Automotive news, Nepal Auto, Auto Price, Nepal, Auto News')
@section('description',  'Leading source for latest Auto News in Nepal. Breaking Auto coverage at your finger tips. Bookmark us and stay up to date with Auto news.')
@section('url',   url('/contact-us') )
@section('image',  URL::to('photos/uploads/2017/05/logo.png'))

@section('content')
    <div class="col-sm-9">
        <div class="row">
            <div class="mar-bot-40 col-sm-4">
                <h1>Contact Us</h1>
                <h3>Nepal Auto Info</h3>
                <p>New Baneshwor, Kathmandu</p>
                <p> Ph: 9851150161, 9849938393, 9851011777 </p>
                <!-- <p> Fax: 977-01-4255216 </p> -->
                <p> Web: <a href="www.nepalauto.com">www.nepalauto.com</a> </p>
                <p>E-mail: <a href="mailto: nepalauto.info@gmail.com">nepalauto.info@gmail.com</a>
            </div>
            <div class="mar-bot-40 col-sm-8">
                <form class="form-horizontal" name="contactsend" id="contactsend" action="{{route('frontend.contactsend')}}" method="post">

                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="fullName" class="col-sm-12 control-label lft-align">Fulll Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="fullName" id="fullName" placeholder="Full Name"
                                   value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="emailId" class="col-sm-12 control-label lft-align">Email Address</label>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" name="emailId" id="emailId" placeholder="Email Address"
                                   value="" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phonenumber" class="col-sm-12 control-label lft-align">Phone Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="phonenumber" id="phonenumber" placeholder="Phone Number"
                                   value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-12 control-label lft-align">Your Message</label>
                        <div class="col-sm-12">
                            <textarea name="message" class="form-control" id="message" cols="30" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-more" value="Send">

                        </div>

                    </div>


                </form>
            </div>
        </div>


    </div>
@endsection
