<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':Attribute ফিল্ডটি গ্রহণযোগ্য হতে হবে।',
    'accepted_if' => ':Attribute ফিল্ডটি :other হয় :value হলে গ্রহণযোগ্য হতে হবে।',
    'active_url' => ':Attribute ফিল্ডটি একটি বৈধ URL হতে হবে।',
    'after' => ':Attribute ফিল্ডটি :date এর পরের তারিখ হতে হবে।',
    'after_or_equal' => ':Attribute ফিল্ডটি :date তারিখের সমান বা পরের তারিখ হতে হবে।',
    'alpha' => ':Attribute ফিল্ডটি শুধুমাত্র অক্ষর ধারণ করতে পারে।',
    'alpha_dash' => ':Attribute ফিল্ডটি শুধুমাত্র অক্ষর, সংখ্যা, ড্যাশ এবং আন্ডারস্কোর ধারণ করতে পারে।',
    'alpha_num' => ':Attribute ফিল্ডটি শুধুমাত্র অক্ষর এবং সংখ্যা ধারণ করতে পারে।',
    'array' => ':Attribute ফিল্ডটি একটি অ্যারে হতে হবে।',
    'ascii' => ':Attribute ফিল্ডটি শুধুমাত্র এক-বাইট অ্যালফানিউমেরিক অক্ষর এবং প্রতীক ধারণ করতে পারে।',
    'before' => ':Attribute ফিল্ডটি :date এর পূর্বের তারিখ হতে হবে।',
    'before_or_equal' => ':Attribute ফিল্ডটি :date তারিখের সমান বা পূর্বের তারিখ হতে হবে।',
    'between' => [
        'array' => ':Attribute ফিল্ডটি কমপক্ষে :min এবং সর্বাধিক :max আইটেম থাকতে হবে।',
        'file' => ':Attribute ফিল্ডটি :min এবং সর্বাধিক :max কিলোবাইটের মধ্যে হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি :min এবং সর্বাধিক :max এর মধ্যে হতে হবে।',
        'string' => ':Attribute ফিল্ডটি কমপক্ষে :min এবং সর্বাধিক :max অক্ষর থাকতে হবে।',
    ],
    'boolean' => ':Attribute ফিল্ডটি সত্য বা মিথ্যা হতে হবে।',
    'can' => ':Attribute ফিল্ডটি অননুমোদিত মান ধারণ করে।',
    'confirmed' => ':Attribute ফিল্ডটি নিশ্চিতকরণের সাথে মेल খায় না।',
    'current_password' => 'পাসওয়ার্ডটি সঠিক নয়।',
    'date' => ':Attribute ফিল্ডটি একটি বৈধ তারিখ হতে হবে।',
    'date_equals' => ':Attribute ফিল্ডটি :date তারিখের সমান হতে হবে।',
    'date_format' => ':Attribute ফিল্ডটি :format ফর্ম্যাটের সাথে মेल খেতে হবে।',
    'decimal' => ':Attribute ফিল্ডটি :decimal দশমিক স্থান থাকতে হবে।',
    'declined' => ':Attribute ফিল্ডটি অস্বীকৃত হতে হবে।',
    'declined_if' => ':other হয় :value হলে :Attribute ফিল্ডটি অস্বীকৃত হতে হবে।',
    'different' => ':Attribute এবং :other ফিল্ডগুলি অবশ্যই ভিন্ন হতে হবে।',
    'digits' => ':Attribute ফিল্ডটি :digits সংখ্যা থাকতে হবে।',
    'digits_between' => ':Attribute ফিল্ডটি :min এবং সর্বাধিক :max সংখ্যা থাকতে হবে।',
    'dimensions' => ':Attribute ফিল্ডটির অবৈধ ইমেজ মাত্রা রয়েছে।',
    'distinct' => ':Attribute ফিল্ডটিতে ডুপ্লিকেট মান রয়েছে।',
    'doesnt_end_with' => ':Attribute ফিল্ডটি নিম্নলিখিতগুলির কোনটির সাথে শেষ হতে পারে না: :values.',
    'doesnt_start_with' => ':Attribute ফিল্ডটি নিম্নলিখিতগুলির কোনটির সাথে শুরু হতে পারে না: :values.',
    'email' => ':Attribute ফিল্ডটি একটি বৈধ ইমেল ঠিকানা হতে হবে।',
    'ends_with' => ':Attribute ফিল্ডটি নিম্নলিখিতগুলির একটির সাথে শেষ হতে হবে: :values.',
    'enum' => 'নির্বাচিত :Attribute অবৈধ।',
    'exists' => 'নির্বাচিত :Attribute অবৈধ।',
    'file' => ':Attribute ফিল্ডটি একটি ফাইল হতে হবে।',
    'filled' => ':Attribute ফিল্ডটির একটি মান থাকতে হবে।',
    'gt' => [
        'array' => ':Attribute ফিল্ডটি :value আইটেমের চেয়ে বেশি থাকতে হবে।',
        'file' => ':Attribute ফিল্ডটি :value কিলোবাইটের চেয়ে বড় হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি :value এর চেয়ে বড় হতে হবে।',
        'string' => ':Attribute ফিল্ডটি :value অক্ষরের চেয়ে বড় হতে হবে।',
    ],
    'gte' => [
        'array' => ':Attribute ফিল্ডটি :value আইটেম বা তার বেশি থাকতে হবে।',
        'file' => ':Attribute ফিল্ডটি :value কিলোবাইটের চেয়ে বড় বা সমান হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি :value এর চেয়ে বড় বা সমান হতে হবে।',
        'string' => ':Attribute ফিল্ডটি :value অক্ষর বা তার বেশি থাকতে হবে।',
    ],
    'image' => ':Attribute ফিল্ডটি একটি ছবি হতে হবে।',
    'in' => 'নির্বাচিত :Attribute অবৈধ।',
    'in_array' => ':Attribute ফিল্ডটি :other এ থাকতে হবে।',
    'integer' => ':Attribute ফিল্ডটি পূর্ণসংখ্যা হতে হবে।',
    'ip' => ':Attribute ফিল্ডটি একটি বৈধ IP ঠিকানা হতে হবে।',
    'ipv4' => ':Attribute ফিল্ডটি একটি বৈধ IPv4 ঠিকানা হতে হবে।',
    'ipv6' => ':Attribute ফিল্ডটি একটি বৈধ IPv6 ঠিকানা হতে হবে।',
    'json' => ':Attribute ফিল্ডটি একটি বৈধ JSON স্ট্রিং হতে হবে।',
    'lowercase' => ':Attribute ফিল্ডটি ছোট হাতের অক্ষরে হতে হবে।',
    'lt' => [
        'array' => ':Attribute ফিল্ডটি :value আইটেমের চেয়ে কম থাকতে হবে।',
        'file' => ':Attribute ফিল্ডটি :value কিলোবাইটের চেয়ে কম হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি :value এর চেয়ে কম হতে হবে।',
        'string' => ':Attribute ফিল্ডটি :value অক্ষরের চেয়ে কম হতে হবে।',
    ],
    'lte' => [
        'array' => ':Attribute ফিল্ডটি :value আইটেমের বেশি হতে পারে না।',
        'file' => ':Attribute ফিল্ডটি :value কিলোবাইটের চেয়ে কম বা সমান হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি :value এর চেয়ে কম বা সমান হতে হবে।',
        'string' => ':Attribute ফিল্ডটি :value অক্ষরের বেশি বা সমান হতে পারে না।',
    ],
    'mac_address' => ':Attribute ফিল্ডটি একটি বৈধ MAC ঠিকানা হতে হবে।',
    'max' => [
        'array' => ':Attribute ফিল্ডটি :max আইটেমের বেশি থাকতে পারে না।',
        'file' => ':Attribute ফিল্ডটি :max কিলোবাইটের চেয়ে বড় হতে পারে না।',
        'numeric' => ':Attribute ফিল্ডটি :max এর চেয়ে বড় হতে পারে না।',
        'string' => ':Attribute ফিল্ডটি :max অক্ষরের চেয়ে বড় হতে পারে না।',
    ],
    'max_digits' => ':Attribute ফিল্ডটি :max সংখ্যা অতিক্রম করতে পারে না।',
    'mimes' => ':Attribute ফিল্ডটি :values ধরনের ফাইল হতে হবে।',
    'mimetypes' => ':Attribute ফিল্ডটি :values ধরনের ফাইল হতে হবে।',
    'min' => [
        'array' => ':Attribute ফিল্ডটি কমপক্ষে :min আইটেম থাকতে হবে।',
        'file' => ':Attribute ফিল্ডটি কমপক্ষে :min কিলোবাইট হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি কমপক্ষে :min হতে হবে।',
        'string' => ':Attribute ফিল্ডটি কমপক্ষে :min অক্ষর থাকতে হবে।',
    ],
    'min_digits' => ':Attribute ফিল্ডটি কমপক্ষে :min সংখ্যা থাকতে হবে।',
    'missing' => ':Attribute ফিল্ডটি ont থাকতে হবে।',
    'missing_if' => ':other হয় :value হলে :Attribute ফিল্ডটি অনুপস্থিত থাকতে হবে।',
    'missing_unless' => ':other হয় :value না হলে :Attribute ফিল্ডটি অনুপস্থিত থাকতে হবে।',
    'missing_with' => ':values উপস্থিত থাকলে :Attribute ফিল্ডটি অনুপস্থিত থাকতে হবে।',
    'missing_with_all' => ':values উপস্থিত থাকলে :Attribute ফিল্ডটি অনুপস্থিত থাকতে হবে।',
    'multiple_of' => ':Attribute ফিল্ডটি :value এর গুণিতক হতে হবে।',
    'not_in' => 'নির্বাচিত :Attribute অবৈধ।',
    'not_regex' => ':Attribute ফিল্ডটির ফর্ম্যাট অবৈধ।',
    'numeric' => ':Attribute ফিল্ডটি একটি সংখ্যা হতে হবে।',
    'password' => [
        'letters' => ':Attribute ফিল্ডটি কমপক্ষে একটি অক্ষর ধারণ করতে হবে।',
        'mixed' => ':Attribute ফিল্ডটি কমপক্ষে একটি বড় হাতের অক্ষর এবং একটি ছোট হাতের অক্ষর ধারণ করতে হবে।',
        'numbers' => ':Attribute ফিল্ডটি কমপক্ষে একটি সংখ্যা ধারণ করতে হবে।',
        'symbols' => ':Attribute ফিল্ডটি কমপক্ষে একটি প্রতীক ধারণ করতে হবে।',
        'uncompromised' => 'প্রদত্ত :Attribute একটি ডেটা লিকে উপস্থিত হয়েছে। অনুগ্রহ করে একটি ভিন্ন :Attribute নির্বাচন করুন।',
    ],
    'present' => ':Attribute ফিল্ডটি উপস্থিত থাকতে হবে।',
    'prohibited' => ':Attribute ফিল্ডটি নিষিদ্ধ।',
    'prohibited_if' => ':other হয় :value হলে :Attribute ফিল্ডটি নিষিদ্ধ।',
    'prohibited_unless' => ':other হয় :values এ না থাকলে :Attribute ফিল্ডটি নিষিদ্ধ।',
    'prohibits' => ':Attribute ফিল্ডটি :other এর উপস্থিতি নিষিদ্ধ করে।',
    'regex' => ':Attribute ফিল্ডটির ফর্ম্যাট অবৈধ।',
    'required' => ':Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_array_keys' => ':Attribute ফিল্ডটি নিম্নলিখিত এন্ট্রিগুলি ধারণ করতে হবে: :values.',
    'required_if' => ':other হয় :value হলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_if_accepted' => ':other গৃহীত হলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_unless' => ':other হয় :values এ না থাকলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_with' => ':values উপস্থিত থাকলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_with_all' => ':values উপস্থিত থাকলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_without' => ':values অনুপস্থিত থাকলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'required_without_all' => ':values এর কোনটিই অনুপস্থিত না থাকলে :Attribute ফিল্ডটি প্রয়োজনীয়।',
    'same' => ':Attribute ফিল্ডটি :other এর সাথে মेल খেতে হবে।',
    'size' => [
        'array' => ':Attribute ফিল্ডটি :size আইটেম থাকতে হবে।',
        'file' => ':Attribute ফিল্ডটি :size কিলোবাইট হতে হবে।',
        'numeric' => ':Attribute ফিল্ডটি :size হতে হবে।',
        'string' => ':Attribute ফিল্ডটি :size অক্ষর থাকতে হবে।',
    ],
    'starts_with' => ':Attribute ফিল্ডটি নিম্নলিখিতগুলির একটির সাথে শুরু হতে হবে: :values.',
    'string' => ':Attribute ফিল্ডটি একটি স্ট্রিং হতে হবে।',
    'timezone' => ':Attribute ফিল্ডটি একটি বৈধ সময় অঞ্চল হতে হবে।',
    'unique' => ':Attribute ইতিমধ্যেই ব্যবহৃত হয়েছে।',
    'uploaded' => ':Attribute আপলোড করতে ব্যর্থ হয়েছে।',
    'uppercase' => ':Attribute ফিল্ডটি বড় হাতের অক্ষরে হতে হবে।',
    'url' => ':Attribute ফিল্ডটি একটি বৈধ URL হতে হবে।',
    'ulid' => ':Attribute ফিল্ডটি একটি বৈধ ULID হতে হবে।',
    'uuid' => ':Attribute ফিল্ডটি একটি বৈধ UUID হতে হবে।',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
