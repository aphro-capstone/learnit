<div class="row">

	<div id="left-div">
		<div class="heading">
			<div class="img-container image-circular">
				<img src="<?= base_url() . getSessionData('sess_userImage'); ?>">
			</div>
			<h2> Chats </h2>
			<div class="dropdown">
				<span data-toggle="dropdown" class="icon"> <i class="fa fa-cog" data-toggle="tooltip" data-placement="bottom" data-original-title="Settings"></i>  </span>
				<ul class="dropdown-menu no-wrap" >
					<li> <a href="#"> <i class="fa fa-cog text-info"></I> Settings </a></li>
					<hr class="mt-1 mb-1">
					<li> <a href="#"> <i class="fa fa-circle text-primary"></i> Active Contacts </a></li>
					<li> <a href="#"> <i class="fa fa-child text-info"></i> Students </a></li>
					<li> <a href="#"> <i class="fa fa-user text-info"></i> Teachers </a></li>
					<li> <a href="#"> <i class="fa fa-envelope text-warning"></i> Unread Messages </a></li>
				</ul>
			</div>
			<span class="clickable-content icon"> <i class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" data-original-title="New Message"  ></i></span>
		</div>
		<div class="content">
			<div class="search-message">
				<i class="fa fa-search"> </i>
				<input type="text" name="search_messages" placeholder="Search Messages">
			</div>
			<div class="conversations show">
				<div class="convo-item">
					<div class="img-container contact-image">
						<img src="<?=base_url()?>assets/images/avatars/user5.png	">
					</div>
					<div class="convoname">
						<span class="convo-name d-block"> Jesther Gonzales </span>
						<span class="conversion-msg"> You : Hi, how are you?  <i class="separator"></i> 4:00 PM </span>
					</div>

					<div class="dropdown option">
						<span data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i></span>
						<ul class="dropdown-menu no-wrap" >
							<li> <a href="#"> <i class="fa fa-volume-off text-primary"></I> Mute </a></li>
							<hr class="mt-1 mb-1">
							<li> <a href="#"> <i class="fa fa-eye-slash text-info"></i> Hide </a></li>
							<li> <a href="#"> <i class="fa fa-trash text-danger" ></i> Delete </a></li>
							<li> <a href="#"> <i class="fa fa-envelope text-info"></i> Mark as unread </a></li>
						</ul>
					</div>
				</div>

				<div class="convo-item">
					<div class="img-container contact-image">
						<img src="<?=base_url()?>assets/images/avatars/user2.png	">
					</div>
					<div class="contactname">
						<span class="contact-name d-block"> Virna Alquizar </span>
						<span class="conversion-msg"> You : Wat's up?  <i class="separator"></i> 3:16 PM </span>
					</div>

					<div class="dropdown option">
						<span data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i></span>
						<ul class="dropdown-menu no-wrap" >
							<li> <a href="#"> <i class="fa fa-volume-off text-primary"></I> Mute </a></li>
							<hr class="mt-1 mb-1">
							<li> <a href="#"> <i class="fa fa-eye-slash text-info"></i> Hide </a></li>
							<li> <a href="#"> <i class="fa fa-trash text-danger" ></i> Delete </a></li>
							<li> <a href="#"> <i class="fa fa-envelope text-info"></i> Mark as unread </a></li>
						</ul>
					</div>
				</div>

				<div class="convo-item">
					<div class="img-container contact-image">
						<img src="<?=base_url()?>assets/images/avatars/user3.png	">
					</div>
					<div class="contactname">
						<span class="contact-name d-block"> Aquim Concepcion </span>
						<span class="conversion-msg"> You : Be there in a minute  <i class="separator"></i> 2:20 PM </span>
					</div>

					<div class="dropdown option">
						<span data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i></span>
						<ul class="dropdown-menu no-wrap" >
							<li> <a href="#"> <i class="fa fa-volume-off text-primary"></I> Mute </a></li>
							<hr class="mt-1 mb-1">
							<li> <a href="#"> <i class="fa fa-eye-slash text-info"></i> Hide </a></li>
							<li> <a href="#"> <i class="fa fa-trash text-danger" ></i> Delete </a></li>
							<li> <a href="#"> <i class="fa fa-envelope text-info"></i> Mark as unread </a></li>
						</ul>
					</div>
				</div>

				<div class="convo-item">
					<div class="img-container contact-image">
						<img src="<?=base_url()?>assets/images/avatars/user4.png	">
					</div>
					<div class="contactname">
						<span class="contact-name d-block"> Aphrodite Gajo </span>
						<span class="conversion-msg"> You : Buy me something  <i class="separator"></i> 1:16 PM </span>
					</div>

					<div class="dropdown option">
						<span data-toggle="dropdown"> <i class="fa fa-ellipsis-h"></i></span>
						<ul class="dropdown-menu no-wrap" >
							<li> <a href="#"> <i class="fa fa-volume-off text-primary"></I> Mute </a></li>
							<hr class="mt-1 mb-1">
							<li> <a href="#"> <i class="fa fa-eye-slash text-info"></i> Hide </a></li>
							<li> <a href="#"> <i class="fa fa-trash text-danger" ></i> Delete </a></li>
							<li> <a href="#"> <i class="fa fa-envelope text-info"></i> Mark as unread </a></li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="contacts">
				<div class="contact-item">
					<div class="img-container convo-image">
						<img src="<?=base_url()?>assets/images/avatars/user2.png	">
					</div>
					<div class="contactname"> Aphrodite Gajo </div>
				</div>
				<div class="contact-item">
					<div class="img-container convo-image">
						<img src="<?=base_url()?>assets/images/avatars/user3.png	">
					</div>
					<div class="contactname"> Aphrodite Gajo </div>
				</div>
				<div class="contact-item">
					<div class="img-container convo-image">
						<img src="<?=base_url()?>assets/images/avatars/user4.png	">
					</div>
					<div class="contactname"> Aphrodite Gajo </div>
				</div>
				<div class="contact-item">
					<div class="img-container convo-image">
						<img src="<?=base_url()?>assets/images/avatars/user5.png	">
					</div>
					<div class="contactname"> Aphrodite Gajo </div>
				</div>
			</div>
		</div>
	</div>
	<div id="conversation-div">
		<div class="heading">
			<div class="img-container image-circular" >
				<img src="<?= base_url(); ?>assets/images/avatars/user5.png">
			</div>
			<div class="text">
				<span class="name d-block"> Jesther Gonzales </span>	
				<span class="active"> Active an hour ago </span>	
			</div>
			<span class="icon"> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom" data-original-title="Conversation Information"  ></i></span>
			<span class="icon ml-2"> <i class="fas fa-video" data-toggle="tooltip" data-placement="bottom" data-original-title="Start a video chat"  ></i></span>
			<span class="icon ml-2"> <i class="fa fa-phone" data-toggle="tooltip" data-placement="bottom" data-original-title="Start a voice call"  ></i></span>	
		</div>
		<div class="conversation-content p-3">
			<div class="msg-item sender-msg new-msg">
				<div class="user-img img-container img-circular"> 
					<img src="<?= base_url();?>assets/images/avatars/user5.png" alt="">
				</div>
				<div class="msg-content">
					<div class="content" data-toggle="tooltip" data-placement="top" data-original-title="10:31 AM"> Hey </div>	
					<div class="actions">
						<div class="reaction-div d-flex">
							<div class="reactions">
								<div class="">
									<div class="reaction-item reaction-like "></div>
									<div class="reaction-item reaction-love "></div>
									<div class="reaction-item reaction-haha "></div>
									<div class="reaction-item reaction-wow "></div>
									<div class="reaction-item reaction-sad "></div>
									<div class="reaction-item reaction-angry "></div>
								</div>
							</div>
							<span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>
						</div>
						
						<span class="icon"> <i class="fa fa-reply"></i> </span>
						<div class="dropdown more">
							<span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>  </span>
							<ul class="dropdown-menu no-wrap normal-padding-dd" >
								<li> <a href="#"> <i class="fa fa-trash text-danger"></I> Remove </a></li>
							</ul>
						</div>
						
					</div>
				</div>
				
			</div>

			<div class="msg-item sender-msg continueous-msg">
				<div class="user-img img-container img-circular"> 
					<img src="<?= base_url();?>assets/images/avatars/user5.png" alt="">
				</div>
				<div class="msg-content" data-toggle="tooltip" data-placement="top" data-original-title="10:35 AM">
					<div class="content">Check this photo </div>
					<div class="actions">
						<div class="reaction-div d-flex">
							<div class="reactions">
								<div class="">
									<div class="reaction-item reaction-like "></div>
									<div class="reaction-item reaction-love "></div>
									<div class="reaction-item reaction-haha "></div>
									<div class="reaction-item reaction-wow "></div>
									<div class="reaction-item reaction-sad "></div>
									<div class="reaction-item reaction-angry "></div>
								</div>
							</div>
							<span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>
						</div>
						
						<span class="icon"> <i class="fa fa-reply"></i> </span>
						<div class="dropdown more">
							<span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>  </span>
							<ul class="dropdown-menu no-wrap normal-padding-dd" >
								<li> <a href="#"> <i class="fa fa-trash text-danger"></I> Remove </a></li>
							</ul>
						</div>
						
					</div>
				</div>
				
			</div>

			<div class="msg-item sender-msg continueous-msg img-attachment">
				<div class="user-img img-container img-circular"> 
					<img src="<?= base_url();?>assets/images/avatars/user5.png" alt="">
				</div>
				<div class="msg-content" data-toggle="tooltip" data-placement="top" data-original-title="10:35 AM">
					<div class="img-container">
						<img src="<?=base_url()?>assets/images/background.jpg" alt="">
					</div>
					<div class="reaction-div d-flex">
						<div class="reactions">
							<div class="">
								<div class="reaction-item reaction-like "></div>
								<div class="reaction-item reaction-love "></div>
								<div class="reaction-item reaction-haha "></div>
								<div class="reaction-item reaction-wow "></div>
								<div class="reaction-item reaction-sad "></div>
								<div class="reaction-item reaction-angry "></div>
							</div>
						</div>
						<span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>
					</div>
					<div class="actions">
						<span class="icon" data-toggle="tooltip" data-placement="top" data-original-title="Download"> <i class="fa fa-download"></i> </span>
						<span class="icon" data-toggle="tooltip" data-placement="top" data-original-title="Reply"> <i class="fa fa-reply"></i> </span>
						<div class="dropdown more">
							<span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>  </span>
							<ul class="dropdown-menu no-wrap normal-padding-dd" >
								<li> <a href="#"> <i class="fa fa-trash text-danger"></I> Remove </a></li>
							</ul>
						</div>
						
					</div>
				</div>
			</div>



			<div class="msg-item receiver-msg new-msg">
				
				<div class="msg-content" >
					
					<div class="content" data-toggle="tooltip" data-placement="top" data-original-title="10:31 AM">Yoo!!</div>
					<div class="actions">
						<div class="dropdown more">
							<span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>  </span>
							<ul class="dropdown-menu no-wrap normal-padding-dd" >
								<li> <a href="#"> <i class="fa fa-trash text-danger"></I> Remove </a></li>
							</ul>
						</div>
						<span class="icon"> <i class="fa fa-reply"></i> </span>
							<div class="reaction-div d-flex">
							<div class="reactions">
								<div class="">
									<div class="reaction-item reaction-like "></div>
									<div class="reaction-item reaction-love "></div>
									<div class="reaction-item reaction-haha "></div>
									<div class="reaction-item reaction-wow "></div>
									<div class="reaction-item reaction-sad "></div>
									<div class="reaction-item reaction-angry "></div>
								</div>
							</div>
							<span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>
						</div>
						
					</div>
				
				</div>
				
				
			</div>
			<div class="msg-item receiver-msg continueous-msg">
				<div class="msg-content" >
					<div class="content" data-toggle="tooltip" data-placement="top" data-original-title="10:35 AM">Cool!! We have both wallpaper. </div>
					<div class="actions">
						
						<div class="dropdown more">
							<span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>  </span>
							<ul class="dropdown-menu no-wrap normal-padding-dd" >
								<li> <a href="#"> <i class="fa fa-trash text-danger"></I> Remove </a></li>
							</ul>
						</div>
						<span class="icon"> <i class="fa fa-reply"></i> </span>
						
						<div class="reaction-div d-flex">
							<div class="reactions">
								<div class="">
									<div class="reaction-item reaction-like "></div>
									<div class="reaction-item reaction-love "></div>
									<div class="reaction-item reaction-haha "></div>
									<div class="reaction-item reaction-wow "></div>
									<div class="reaction-item reaction-sad "></div>
									<div class="reaction-item reaction-angry "></div>
								</div>
							</div>
							<span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>
						</div>
					</div>
				</div>
			</div>
			<div class="msg-item receiver-msg continueous-msg img-attachment">
				
				<div class="msg-content" >
					<div class="img-container" data-toggle="tooltip" data-placement="top" data-original-title="10:35 AM">
						<img src="<?=base_url()?>assets/images/background.jpg" alt="">
					</div>
					<div class="reaction-div d-flex">
						<div class="reactions">
							<div class="">
								<div class="reaction-item reaction-like "></div>
								<div class="reaction-item reaction-love "></div>
								<div class="reaction-item reaction-haha "></div>
								<div class="reaction-item reaction-wow "></div>
								<div class="reaction-item reaction-sad "></div>
								<div class="reaction-item reaction-angry "></div>
							</div>
						</div>
						<span class="icon reaction-trigger"> <i class="fa fa-smile-o"></i> </span>
					</div>
					<div class="actions">
						<div class="dropdown more">
							<span data-toggle="dropdown" class="icon"> <i class="fa fa-ellipsis-h" data-toggle="tooltip" data-placement="bottom" data-original-title="More"></i>  </span>
							<ul class="dropdown-menu no-wrap normal-padding-dd" >
								<li> <a href="#"> <i class="fa fa-trash text-danger"></I> Remove </a></li>
							</ul>
						</div>
						<span class="icon" data-toggle="tooltip" data-placement="top" data-original-title="Reply"> <i class="fa fa-reply"></i> </span>
						<span class="icon" data-toggle="tooltip" data-placement="top" data-original-title="Download"> <i class="fa fa-download"></i> </span>
						
					</div>
				</div>
				
			</div>

		</div>
		<div class="footer">
			<span class="icon" data-toggle="tooltip" data-placement="top" data-original-title="Take a Photo"> <i class="fa fa-camera-retro"></i> </span>
			<span class="icon" data-toggle="tooltip" data-placement="top" data-original-title="Add files"> <i class="fa fa-file-image-o"></i> </span>
			<div class="text-input">
				<textarea  placeholder="Message ..."></textarea>
				<span class="emoji-btn icon"> <i class="fa fa-smile-o"> </i> </span>
			</div>
			<span class="sendicon icon" data-toggle="tooltip" data-placement="top" data-original-title="Send Message"> <i class="fa fa-paper-plane "></i> </span>
		</div>
	</div>
</div>