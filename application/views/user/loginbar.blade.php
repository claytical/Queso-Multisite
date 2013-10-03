	<ul class="nav navbar-nav pull-right">
        <li><a href="{{URL::to('register')}}">Sign Up</a></li>
        <li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown">Login <strong class="caret"></strong></a>
						<div class="dropdown-menu">
                            <div class="container">
							<?php echo Form::open('login', 'POST'); ?>
								    <!-- username field -->
                                    <?php echo Form::label('email', 'Email Address'); ?>
                                    @if(Cookie::get('remember'))
                                    <?php echo Form::text('email', Cookie::get('email'), array('class' => 'input-sm form-control')); ?>
                                    <!-- password field -->
                                    @else
                                    <?php echo Form::text('email', '', array('autocomplete' => 'off', 'class' => 'input-sm form-control')); ?>
                                    @endif
                                    <?php echo Form::label('password', 'Password'); ?>
                                    <?php echo Form::password('password', array('class' => 'input-sm form-control')); ?>
                                    <div class="checkbox" style="width: 200px">
                                        <label>
                                        @if(Cookie::get('remember'))    
                                        <?php echo Form::checkbox('remember', 1, true); ?>
                                        @else
                                        <?php echo Form::checkbox('remember', 1, false); ?>        
                                        @endif
                                            Remember Me</label>
                                    </div>

								<input class="btn btn-primary btn-block" type="submit" id="login" value="Login">
                            <?php echo Form::close(); ?>

                            <p class="help-block"><a href="{{URL::to('forgot')}}" class="">Reset Password</a></p>
                            </div>
                        </div>
					</li>
                </ul>
