Components Making
>>>php artisan make:component Alert
app>views
resource>views>components ဖိုင်နှစ်ခုတိုးပါသည်။

components ထဲက blade မှာရေးတာပါ>>>  <div class="alert alert-info">
                                                           <h4>Components</h4>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium at atque distinctio doloremque, ea harum hic illum in ipsam ipsum itaque, maiores molestiae nam obcaecati odit quaerat suscipit tempora ut?</p>
                                    </div>
>>> <x-alert></x-alert> လို့ခေါ်သုံးလို့ရပါ။။။။။

သူ့ရဲ့ Components class မှာ သုံးခုထည့်ခဲံပါ

public $type;
public function __construct($type,$message=""){
$this->type = $type;
}


<div class="alert alert-{{$type}}">
    <h4>{{$message}}</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium at atque distinctio doloremque, ea harum hic illum in ipsam ipsum itaque, maiores molestiae nam obcaecati odit quaerat suscipit tempora ut?</p>
</div>

<x-alert type="error" :message="$message"/>
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
slot
<div class="">
    {{$slot}} က သူ့ရဲ့ ကလပ်မှာ ပြန်ကြေညာပေးစရာမလိုပါ။
</div>

<x-alert>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores debitis delectus ea expedita, facere nesciunt non quasi qui. Adipisci culpa cumque ipsum mollitia necessitatibus nobis, quam voluptates! Dolor id, quis.
</x-alert>



camelCase,=myName
kebab-case=my-name
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

View::share("myName","Zaw Min Htwe");
