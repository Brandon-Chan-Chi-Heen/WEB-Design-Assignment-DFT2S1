<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="index.css" type="text/css" rel="stylesheet">
    <link href="event.css" type="text/css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <?php include "../header.php" ?>
    <?php include "event_helper.php" ?>
    <h1>Event</h1>
    <a href="" class="delete">Delete</a>
    <a href="" class="editButton">Edit</a>
    <a href="" class="uploadButton">Upload</a>
    <br><br>
    <?php echo getEventDetails();?>
<!--    <div class="newRow">
        <div class="Event">
            <div  class="col-1-3 specials">
            <img src="First event.jpg" alt="" />
            </div>
            <div class="col-2-3 specials">
                <div class="Details">
                    <div class="uploadEdit">
                        <h3><a href="" class="bookmark">🔖</a></h3>
                    </div>
                    <h1>Financial Leteracy Workshop</h1>
                    <p> Always heard of Rich Dad Poor Dad, but never knew what it is? 🧐 Then, THIS IS FOR YOU!!
                        Bringing to you, our Financial Literacy Workshop organised by Aspiratio Advisory happening this August‼️ 
                        Come join our team to this fun-filled workshop and gain multiple insights which would enable you to: 
                        ✅ Increase your awareness on the importance of keeping your financials in check
                        ✅ Realize the value of early financial planning 
                        ✅ Gain a valuable exposure towards financial freedom 
                        ✅ FREE Personality Test 
                        ✅ Soft skill points provided
                        ✅ Internship opportunity with Aspiratio Advisory
                        🗓 Mark your calendar! 
                        Date: 1 August 2021 (Sunday) 
                        Time: 2.00pm to 6.00pm 
                        Venue: Zoom
                        Grab your chance now! </p>
                </div>
                <div class="price">
                    <h3><a href="" class="addToCart">🛒</a>$24.95</h3>
                    <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                </div>
            </div>
        </div>
        <div  class="Event">
            <div  class="col-1-3 specials">
                <img src="Second event.jpg" alt="" />
            </div>
            <div class="col-2-3 specials">
                <div class="Details">
                    <div class="uploadEdit">
                    <h3><a href="" class="bookmark">🔖</a></h3>
                    </div>
                    <h1>Investing Note Trading Cup</h1>
                    <p>Hey, you know what? We have a good news for you!!📣
                    Go head-to-head with other traders in the Biggest & Most Exciting Virtual Trading Tournament in Malaysia: 𝐈𝐧𝐯𝐞𝐬𝐭𝐢𝐧𝐠𝐍𝐨𝐭𝐞 𝐓𝐫𝐚𝐝𝐢𝐧𝐠 𝐂𝐮𝐩 𝟐𝟎𝟐𝟏!
                    💡Participants will be given RM100,000 virtual capital to trade Bursa Malaysia listed stock using real market data.
                    💡Total worth up to RM30,000 of GRAND prizes up for win and the tournament is Free-For-All to join! Register, trade and stand a chance to win latest version of Apple Ipad Pro and LUMOS RAY Home Cinema Projector.
                    💡Beginners who are interested to trade but are unsure on how to, this will be a great opportunity for you to get started. If you are already a pro trader,
                     be sure not to miss out on this active trading challenge and stand a chance to walk away with fame, glory and amazing prizes!</p>
                </div>
                <div class="price">
                    <h3><a href="" class="addToCart">🛒</a>$24.95</h3>
                    <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                </div>
            </div>
        </div>
        <div class="Event">
            <div  class="col-1-3 specials">
            <img src="Third event.jpg" alt="" />
            </div>
            <div class="col-2-3 specials">
                <div class="Details">
                    <div class="uploadEdit">
                        <h3><a href="" class="bookmark">🔖</a></h3>
                    </div>
                    <h1>Employee Investor Program</h1>
                    <p>𝐖𝐡𝐨 𝐬𝐚𝐲𝐬 𝐞𝐦𝐩𝐥𝐨𝐲𝐞𝐞𝐬 𝐜𝐚𝐧’𝐭 𝐛𝐞 𝐢𝐧𝐯𝐞𝐬𝐭𝐨𝐫?
                       Introducing Mr Alfred Chen from 松大资本集团 Grandpine Capital who will be conducting a webinar with us on July 8, 2021!!! 
                       Mr Alfred is an experienced and professional investor that you wouldn’t want to miss! This webinar aims to educate students on proper financial planning methods especially when one steps into the corporate world. 
                       𝙎𝙥𝙚𝙘𝙞𝙛𝙞𝙘𝙖𝙡𝙡𝙮, 𝙩𝙝𝙚 𝙥𝙖𝙧𝙩𝙞𝙘𝙞𝙥𝙖𝙣𝙩𝙨 𝙬𝙞𝙡𝙡 𝙗𝙚 𝙚𝙭𝙥𝙤𝙨𝙚𝙙 𝙩𝙤 𝙬𝙤𝙧𝙠𝙥𝙡𝙖𝙘𝙚 𝙞𝙣𝙫𝙚𝙨𝙩𝙢𝙚𝙣𝙩 𝙖𝙨 𝙖 𝙛𝙧𝙚𝙨𝙝 𝙜𝙧𝙖𝙙𝙪𝙖𝙩𝙚 𝙤𝙧 𝙚𝙢𝙥𝙡𝙤𝙮𝙚𝙚!
                       Thirst for knowledge? Wish to stay competitive and relevant? Join us!
                       📌 Date: July 8, 2021 (8PM - 10PM)
                       📌 Venue: Google Meet (link will be provided via WhatsApp upon successful registration)
                       📌 Speaker: Alfred Chen
                       𝗦𝗼𝗳𝘁 𝘀𝗸𝗶𝗹𝗹 𝗽𝗼𝗶𝗻𝘁𝘀 (𝗶𝗻𝗰𝗹𝘂𝗱𝗶𝗻𝗴 𝗞𝗞 𝗽𝗼𝗶𝗻𝘁𝘀) 𝘄𝗶𝗹𝗹 𝗯𝗲 𝗽𝗿𝗼𝘃𝗶𝗱𝗲𝗱.</p>
                </div>
                <div class="price">
                    <h3><a href="" class="addToCart">🛒</a>$24.95</h3>
                    <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                </div>
            </div>
        </div>
        <div class="Event">
            <div  class="col-1-3 specials">
            <img src="Fourth event.jpg" alt="" />
            </div>
            <div class="col-2-3 specials">
                <div class="Details">
                    <div class="uploadEdit">
                        <h3><a href="" class="bookmark">🔖</a></h3>
                    </div>
                    <h1>Power Up Your FQ</h1>
                    <p>
                        We received some enquiries about the Soft Skill Points and entrance fee! ☺️ 
                        📣 Don’t worry, “Power Up You FQ! ” doesn’t require entrance fee, just make sure you’ve filled in & submitted the participant registration form successfully to enroll into the webinar on 10 June ! 👌🏻 
                        📣 And yes! Soft Skill Points will be provided for TARUC students who’re pursuing studies in KL Campus 🥳 (fill in your name, student ID, email & details accurately) 
                        🔥🔥 Participant Registration Form 😎⬇️ easy! https://us02web.zoom.us/.../941.../WN_zyQGXW2dQkmA6uuWDrKSvQ
                        Wish to become our member? Join us at: https://forms.gle/PYHHZWvhVRv31J8K6 
                        Follow our Instagram page: https://www.instagram.com/byic.taruc/
                        Welcome for enquiries! See you on 10 June! 🤩
                    </p>
                </div>
                <div class="price">
                    <h3><a href="" class="addToCart">🛒</a>$35.95</h3>
                    <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                </div>
            </div>
        <div class="Event">
            <div  class="col-1-3 specials">
            <img src="Fifth event.jpg" alt="" />
            </div>
            <div class="col-2-3 specials">
                <div class="Details">
                    <div class="uploadEdit">
                        <h3><a href="" class="bookmark">🔖</a></h3>
                    </div>
                    <h1>3 Wealth Creation Strategies</h1>
                    <p>
                       "Nothing comes easy, but everything is possible" - Ernie Chen
                        Dear Tarcians, we have proudly invited Sifu Ernie Chen, Asia's No.1 Business Coach to conduct a webinar with us!🔥 
                        📆Date= 21/01/21
                        🕰️Time= 8pm-9.30pm
                        💻Venue=Zoom
                        Sifu Ernie is Asia's No.1 Business Coach & also a serial entrepreneur who has mentored, coached & helped many individuals, entrepreneurs, SME business owners, multinational companies all over Asia in the areas of business, marketing, property investments & stock investments📈 He is also a TV& Radio personality, award winning director & a producer producing box office hit movies! 
                        If you are wondering on:
                        1.How to create a cash generating machine to increase cash flow immediately both online & offline?
                        2. How to invest in stock market to generate 30% ROI consistently without any technical knowledge?
                        3. How to invest with very little or no money down in properties with other peoples' money & gain massive capital gains?
                    </p>
                </div>
                <div class="price">
                    <h3><a href="" class="addToCart">🛒</a>$16.95</h3>
                    <a href="" class="enrollNow"><h3>Enroll Now</h3></a>
                </div>
            </div>
        </div>
    </div>-->
    <?php include "../footer.html" ?>
</body>
</html>