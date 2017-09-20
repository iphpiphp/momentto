<div class="container">

    <form class="form-horizontal" role="form" id="register_form" method="post" action="/auth/register_chk">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-1 control-label">이메일</label>
            <div class="col-sm-8">
                <input type="email" name="register_email" id="register_email" class="form-control" id="inputEmail3" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-1 control-label">패스워드</label>
            <div class="col-sm-8">
                <input type="password" name="register_password" id="register_password" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-1 control-label">패스워드확인</label>
            <div class="col-sm-8">
                <input type="password" name="register_password_rw" id="register_password_rw" class="form-control" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-8">
                <div><textarea style="width:100%">이용약관</textarea></div>
                <div><textarea style="width:100%">개인정보방침</textarea></div>
            <input type="checkbox" id="register_agree"><label for="chk" class="">정책에 동의</label>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-8">
                <button id="register_btn" class="btn btn-default">
                    회원가입
                </button>
            </div>
        </div>
    </form>
    
    
        

</div>