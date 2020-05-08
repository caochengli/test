<?php
return array(

    'AlipayCharge' => array(
        'use_sandbox'           => false,
        'partner'               => '2088721408156585',
        'app_id'                => '2017070707670257',
        'sign_type'             => 'RSA2',
        'ali_public_key'        => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoID7OalnuRKNy/wXm5HPgk+4/wCQzBj+gPUiE4qgWy6laPIcoJX18nt2AriH0bPJ4+XovRS3hFxkRdY/EfjgXx/UxcpLZTwxweF/GWoL3qc9mq5GSj8M/gKk8FAjw6sIqSBJ/upz/3yEboPgkIrX839kuLbHvr6Kqwzga3jZndfv0z+y1lQLOR2pKZfPYI2ftdyWTTsv8gG+1s60Eadsn4QjZ6zEwYl9pcfORp0fpi83BiCQ//suJJIAVzwqY1ZVu507grzQBzg8fwzZFF2qCHexd6aNNTyNHegpLVDDek12p9T+m6b0gTS7ku99U5uVYakf4vTSXLd5q/JqE44DIQIDAQAB',
        'rsa_private_key'       => 'MIIEpAIBAAKCAQEA4dBG/adQj88c+L8ZKUq2BRZ51J8d8v/ZeVuZce9enV4Zb2q4JyLOZXwfW0X3of5wSg3qy5wt7k0VEYKfWxINjqRsC78sqblhRUYkrwrlMFb+w9o0srrU7Ggq5hiG4pL4nEUzMNBe1p11Uw9ecBr4dh6u/6N56ADAO4yIgQgsgrwcOptQ05YckcfVpFwihJgqbmtcRwhU4pKShsGlPe3/UFkz6GE5hCWX8w4bKncuunyltzu8SstUjvq4DNeHXOLBM4MAtfEvsw06OyKMVnOjxa6O66IRvZmYYITrTdw/0WC1IgOHIQrbBAZJvxM4c6EIp3kKROdS2WU5fdAsuz0tDwIDAQABAoIBAQCbQv6cx17gElLkQVjGiGUQqHyKEgGgpAPeqnmd2ize3OV2MxV9azQomShiNIBotK52bI1FBBScpglXac2x637A1hKoHQFTjW/xFqKAbGhbTWWMOktDnKxsA8+DN9f+j3k60WW6KXsb61XRD18qi5DMfppqkPdv6pxCFYWB2qHoHK3VAQBLya1aQVGXamFM+9yvzEipNkSxOXdzJWyCASGsCVFF4f/E700tleM5r+B5ovtZc7E2wvrb2INRMg8Q01j6dOVJrhr3dOx7wG8q6GAIpU/00mJh+JGjCSTfDzCtb9sEh1qHtz3KV3jRRdAqPUiU36OqsdL41Q8KoPEPvHv5AoGBAP4Wqr+Y/e6POZW1VNV9mq5f+u9ze4y0lgXUHPXhiyaWG6gvtr0AsdUozM+G7vMsjjHYUSVoovgTBM+cHcKWfaCkqgFFKNyO3lRP1DDcgsJRNrDQ+Ww7d89Wzj/WbvepIgCNzlHmUQttiuImeLgE71DBHKeLthMgFfVG7y1pXSE7AoGBAOODKElkNwlK+E6ZLiUQUs0FXFy6jwyePAnp1MFoV2Uo6mq5T+P0+SkEmy25XUgs03SoceT66kj7UEt0J6t0X5VdRMV6UanvcgKlJNWAKKRRz58ZWDA5T4+UpfNZc9y3edxrPo8PWHdvaTlV7O7okfebmF7HXTkkLaPmEdztgKY9AoGAW0zPzArwa9FBMt82fYQlmbTZWUNYyMV3Bt8iDOQfeR0FERkcA6wFOn/voD5vDCgdbCG7fsKrlJJY7zS8qNgkih3BDLXKKf6YOxl4OJpzzdka2swsY8y2j2U0tVGbDBjVI/fQhDNLOd0Bw6NpS05So+TQJBAau6KS4VC8zseGdFMCgYEAu04opbt2wBTTtsnPvr3gnV/zeXgx+x5uqW60NQK1KNh1naWxCyiM1OMw6oT4MkqNUDa5hd25cppMscIQQszNQIgH7VjV0MUMJPdXCtq3GwkrmH1iKFmWkcu8kEst4yG+luRIHblxiOrVQ1nldY9NVP/pguY5bqjFVnE8dZmm17UCgYBmhD6Fu8MhyXXeLTzkLXsZfjoV3rTi4QAzLHvwfo8DHN1Ha1gsobS7i1AFbR3kR60XKTin0MNzbICMsEAgBIl/yGnzjPQkJKKJr9nbOadRyYGj9kNJWIWjCZ9hWSckAZrLtZxshz0EVTYZr3hp19D8PIvzV1Ojhw4y0QKrqq9Azg==',

        'limit_pay'             => [
            //'balance',
            //'moneyFund',
            // ... ...
        ],
        'notify_url'            => 'http://www.mykangjian.com/index.php/Notify/notify/tp/ali',
        'return_url'            => 'http://www.mykangjian.com/index.php/User/index',
        'return_raw'            => false,
    )

);

