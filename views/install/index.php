<div class="container">
    <div class="jumbotron">
        <h1>Welcome to PHPEasy<span><h6 style="display: inline-block;"><?php echo $this -> info -> version?></h6></span></h1> <!-- TODO: Run get newest version --> 
        <h3>PHPEasy is a MVC, CMS Framework. Write on PHP, JS, CSS, HTML5, Bootstrap.</h3>
        <br><br><br>
        <span class="text-right">
            <h5>Made by NeV3RmI</h5>
            <h5>Copyright © 2013 - 2017 Codeasy. All rights reserved.</h5>
        </span>
    </div>
    <form id="install" action="#">
        <div>
            <h3>Terms and Conditions</h3>
            <fieldset>
                <h3 class="text-center">Terms and Conditions</h3>
                <ol>
                    <li><strong>Introduction</strong>
                    </li>
                </ol>
                <p>These Website Standard Terms and Conditions written on this webpage shall manage your use of this website. These Terms will be applied fully and affect to your use of this Website. By using this Website, you agreed to accept all terms and conditions written in here. You must not use this Website if you disagree with any of these Website Standard Terms and Conditions.</p>
                <p>Minors or people below 18 years old are not allowed to use this Website.</p>
                <ol start="2">
                    <li><strong>Intellectual Property Rights</strong>
                    </li>
                </ol>
                <p>Other than the content you own, under these Terms, PHPEasy and/or its licensors own all the intellectual property rights and materials contained in this Website.</p>
                <p>You are granted limited license only for purposes of viewing the material contained on this Website.</p>
                <ol start="3">
                    <li><strong>Restrictions</strong>
                    </li>
                </ol>
                <p>You are specifically restricted from all of the following</p>
                <ul>
                    <li>publishing any Website material in any other media;</li>
                    <li>selling, sublicensing and/or otherwise commercializing any Website material;</li>
                    <li>publicly performing and/or showing any Website material;</li>
                    <li>using this Website in any way that is or may be damaging to this Website;</li>
                    <li>using this Website in any way that impacts user access to this Website;</li>
                    <li>using this Website contrary to applicable laws and regulations, or in any way may cause harm to the Website, or to any person or business entity;</li>
                    <li>engaging in any data mining, data harvesting, data extracting or any other similar activity in relation to this Website;</li>
                    <li>using this Website to engage in any advertising or marketing.</li>
                </ul>
                <p>Certain areas of this Website are restricted from being access by you and PHPEasy may further restrict access by you to any areas of this Website, at any time, in absolute discretion. Any user ID and password you may have for this Website are confidential and you must maintain confidentiality as well.</p>
                <ol start="4">
                    <li><strong>Your Content</strong>
                    </li>
                </ol>
                <p>In these Website Standard Terms and Conditions, “Your Content” shall mean any audio, video text, images or other material you choose to display on this Website. By displaying Your Content, you grant PHPEasy a non-exclusive, worldwide irrevocable, sub licensable license to use, reproduce, adapt, publish, translate and distribute it in any and all media.</p>
                <p>Your Content must be your own and must not be invading any third-party’s rights. PHPEasy reserves the right to remove any of Your Content from this Website at any time without notice.</p>
                <ol start="5">
                    <li><strong>No warranties</strong>
                    </li>
                </ol>
                <p>This Website is provided “as is,” with all faults, and PHPEasy express no representations or warranties, of any kind related to this Website or the materials contained on this Website. Also, nothing contained on this Website shall be interpreted as advising you.</p>
                <ol start="6">
                    <li><strong>Limitation of liability</strong>
                    </li>
                </ol>
                <p>In no event shall PHPEasy, nor any of its officers, directors and employees, shall be held liable for anything arising out of or in any way connected with your use of this Website whether such liability is under contract. &nbsp;PHPEasy, including its officers, directors and employees shall not be held liable for any indirect, consequential or special liability arising out of or in any way related to your use of this Website.</p>
                <ol start="7">
                    <li><strong>Indemnification</strong>
                    </li>
                </ol>
                <p>You hereby indemnify to the fullest extent PHPEasy from and against any and/or all liabilities, costs, demands, causes of action, damages and expenses arising in any way related to your breach of any of the provisions of these Terms.</p>
                <ol start="8">
                    <li><strong>Severability</strong>
                    </li>
                </ol>
                <p>If any provision of these Terms is found to be invalid under any applicable law, such provisions shall be deleted without affecting the remaining provisions herein.</p>
                <ol start="9">
                    <li><strong>Variation of Terms</strong>
                    </li>
                </ol>
                <p>PHPEasy is permitted to revise these Terms at any time as it sees fit, and by using this Website you are expected to review these Terms on a regular basis.</p>
                <ol start="10">
                    <li><strong>Assignment</strong>
                    </li>
                </ol>
                <p>The PHPEasy is allowed to assign, transfer, and subcontract its rights and/or obligations under these Terms without any notification. However, you are not allowed to assign, transfer, or subcontract any of your rights and/or obligations under these Terms.</p>
                <ol start="11">
                    <li><strong>Entire Agreement</strong>
                    </li>
                </ol>
                <p>These Terms constitute the entire agreement between PHPEasy and you in relation to your use of this Website, and supersede all prior agreements and understandings.</p>
                <ol start="12">
                    <li><strong>Governing Law &amp; Jurisdiction</strong>
                    </li>
                </ol>
                <p>These Terms will be governed by and interpreted in accordance with the laws of the State of Vietname, and you submit to the non-exclusive jurisdiction of the state and federal courts located in Vietname for the resolution of any disputes.</p>
                <hr>
                <span class="pull-right">
                    <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms"><b>I agree with the Terms and Conditions.</b></label>
                </span>
            </fieldset>
            <?php
            // TODO: After active license, auto run update.
            ?>
            <h3>License</h3>
            <fieldset>
                <h3 class="text-center">License</h3>
                <div class="form-group">
                    <label for="licenseKey">Key:</label>
                    <input class="license-key-form form-control required" type="text" placeholder="Please insert the key!" name="licenseKey">
                    <input class="license-key-form" type="hidden" class="required" value="<?php echo $this -> data -> ip;?>">
                    <input class="license-key-form" type="hidden" class="required" value="<?php echo $this -> data -> url;?>">
                </div>
            </fieldset>
            <h3>Setup Database</h3>
            <fieldset>
                <h3 class="text-center">Database</h3>
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="hostname">Hostname:</label>
                        <input type="text" class="form-control database-form required">
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control database-form required">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control database-form required">
                    </div>
                    <div class="form-group">
                        <label for="dbname">Database Name:</label>
                        <input type="text" class="form-control database-form required">
                    </div>
                </div>    
            </fieldset>
            <h3>Site Information</h3>
            <fieldset>
                <h3 class="text-center">Site Information</h3>
                <div class="col-md-6 col-md-offset-3">
                    <div class="form-group">
                        <label for="siteName">Site Name:</label>
                        <input type="text" class="form-control siteinfo-form required" placeholder="Codeasy">
                    </div>
                    <div class="form-group">
                        <label for="sitePublisher">Site Publisher:</label>
                        <input type="text" class="form-control siteinfo-form required" placeholder="NeV3RmI">
                    </div>
                    <div class="form-group">
                        <label for="copyrightYear">Copyright Year:</label>
                        <input type="text" class="form-control siteinfo-form required" placeholder="2013 - 2017">
                    </div>
                    <div class="form-group">
                        <label for="fanpage">Facebook Fanpage (Optional):</label>
                        <input type="text" class="form-control siteinfo-form" placeholder="https://www.facebook.com/PHPEasy-1779256929053355/">
                    </div>
                    <div class="form-group">
                        <label for="siteEmail">Site Email:</label>
                        <input type="email" class="form-control siteinfo-form required" placeholder="contact@gmail.com">
                    </div>
                    <div class="form-group">
                        <label for="siteContact">Site Contact:</label>
                        <input type="text" class="form-control siteinfo-form required" placeholder="+84 868 051 858">
                    </div>
                    <div class="form-group">
                        <label for="siteAddress">Company Address:</label>
                        <input type="text" class="form-control siteinfo-form required" placeholder="85/95 Pham Viet Chanh, F19, Binh Thanh District, Ho Chi Minh City">
                    </div>
                    <div class="form-group">
                        <label for="googleSiteVerification"><a href="https://www.google.com/webmasters/tools/" target="_blank">Google Site Verification:</a></label>
                        <input type="text" class="form-control siteinfo-form required" placeholder="Add a property > Alternate methods > HTML tag > Copy Content code">
                    </div>
                    <div class="form-group">
                        <label for="description">Site Description:</label>
                        <textarea class="form-control siteinfo-form required" rows="5" style="resize: vertical;" placeholder="PHPEasy is a PHP MVC, CMS framework, was developed by Codeasy."></textarea>
                    </div>
                </div>
            </fieldset>
            <h3>Setup Google Captcha</h3>
            <fieldset>
                <h3 class="text-center">Google Captcha</h3>
                <div class="col-md-6 col-md-offset-3">
                    <h4>1. Create <a href="https://www.google.com/recaptcha/admin" target="_blank">Google Captcha</a>:</h4>
                    <div class="form-group">
                        <div class="container-fluid">
                            <ul>
                                <li>Create Google account if you don't have one.</li>
                                <li>Register a new site</li>
                                <li>Label: <?php echo $GLOBALS['_Security']::GetKey('siteName') ?></li>
                                <li>Choose the type of reCAPTCHA: reCAPTCHA V2</li>
                                <li>Domains: <?php echo $GLOBALS['_Site'] -> GetUrlNoHttp();?></li>
                                <li>Accept Term and Conditions</li>
                                <li>Register</li>
                                <li>Check Adding reCAPTCHA to your site > Keys > Site key &amp; Secret key
                            </ul>
                        </div>
                    </div>
                    <h4>2. Save Google Captcha:</h4>
                    <div class="form-group">
                        <label for="hostname">Site Key:</label>
                        <input type="text" class="form-control googlecaptcha-form required" placeholder="Use this in the HTML code your site serves to users.">
                    </div>
                    <div class="form-group">
                        <label for="username">Secret Key:</label>
                        <input type="text" class="form-control googlecaptcha-form required" placeholder="Use this for communication between your site and Google. Be sure to keep it a secret.">
                    </div>
                </div>    
            </fieldset>
            <?php
            // TODO: Sau khi tao acc thi tu dong dang nhap va switch install chi cho owners vao thoi :)
            ?>
            <h3>Setup Admin Account</h3>
            <fieldset data-mode="async" data-url="/login/register">
            </fieldset>
        </div>
    </form>
</div>