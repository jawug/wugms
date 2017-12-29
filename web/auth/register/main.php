    <!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="jumbotron">
		<div class="container-fluid">
			<h1>JAWUG User registration</h1>
			<p class="lead">Please read the following carefully and fill in the required fields</p>
		</div>
	</div>
	<!--  role="form"  -->
    <div id="userreg" class="container-fluid">
		<form class="form-horizontal" id="regcv" enctype="multipart/form-data" method="post" action="../register/newuser.php">
			<div class="alert alert-success" style="display: none;"></div>
			<div class="form-group">
				<label class="col-lg-3 control-label">First name</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Last name</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name" />
				</div>
			</div>			
	
			<div class="form-group">
				<label class="col-lg-3 control-label">IRC Nick</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" id="ircnick" name="ircnick" placeholder="IRC Nick" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Phone</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" id="phone" name="phone" placeholder="+27000000000" />
				</div>
			</div>			
		
			<div class="form-group">
				<label class="col-lg-3 control-label">Email</label>
				<div class="col-lg-9">
					<input type="email" class="form-control" id="email" name="email" placeholder="Email address" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Verify email</label>
				<div class="col-lg-9">
					<input type="email" class="form-control" id="verifyemail" name="verifyemail" placeholder="Email verification" />
				</div>
			</div>
			<!--
            <div class="form-group">
                <label class="col-lg-3 control-label">Gender</label>
                    <div class="col-lg-5">
						<div class="radio">
							<label>
								<input type="radio" name="gender" value="male" checked /> Male
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" value="female" /> Female
                            </label>
                        </div>

                    </div>
            </div>
			-->
			<div class="form-group">
				<label class="col-lg-3 control-label">Date of Birth</label>
				<div class="col-lg-9">
					<input type="text" class="form-control" id="dob" name="dob" placeholder="YYYY/MM/DD" />
				</div>
			</div>			
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Password</label>
				<div class="col-lg-9">
					<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Verify password</label>
				<div class="col-lg-9">
					<input type="password" class="form-control" id="verifypassword" name="verifypassword" placeholder="Password verification" />
				</div>
			</div>
			
			<div class="panel panel-primary">
			<div class="panel-heading"><h4>Constitution aka "Terms and conditions"</h4></div>
				<div class="panel-body" style="max-height: 210px;overflow-y: scroll;">
					<p>Constitution of the Johannesburg Area Wireless Users Group (As Adopted)</p>
					<ol style="text-align: justify;">
						<li style="text-align: justify;">Name</li>
							<ol style="text-align: justify;">
								<li>The organisation hereby constituted will be called Johannesburg Area Wireless Users Group</li>
								<li>"JAWUG" is the official abbreviation for the Johannesburg Area Wireless Users Group (hereinafter referred to as the organisation).</li>
							</ol>
						<li style="text-align: justify;">Body corporate &#8211; The organisation shall:</li>
							<ol style="text-align: justify;">
								<li>Exist in its own right, separately from its members.</li>
								<li>Continue to exist even when its membership changes and there are different office bearers.</li>
								<li>Be able to own property and other possessions.</li>
								<li>Be able to sue and be sued in its own name.</li>
							</ol>
						<li style="text-align: justify;">Objectives</li>
							<ol style="text-align: justify;">
								<li>The organisation's main objectives are to develop, build and maintain community owned communications infrastructure for use by its members. The network shall primarily be available for communication between members and for educational and research usage by the members of the organisation.</li>
								<li>The organisation's secondary objectives will be to work in collaboration with other organisations that mainly deal with community communication, education and research.</li>
							</ol>
						<li style="text-align: justify;">Income and property</li>
							<ol style="text-align: justify;">
								<li>The organisation will keep a record of all assets that it owns.</li>
								<li>The organisation may not distribute any of its assets to its members or office bearers except as reasonable compensation for services rendered.</li>
								<li>A member of the organisation may only receive money from the organisation for expenses that she or he has paid for or on behalf of the organisation.</li>
								<li>Members and office bearers of the organisation do not have rights over assets that belong to the organisation.</li>
							</ol>
						<li style="text-align: justify;">Membership</li>
							<ol style="text-align: justify;">
								<li>Application for membership to the organisation is open to any individual that is interested in the activities of the organisation and agrees to comply with the terms and conditions of membership determined by the Management Committee from time to time. The management committee has the right to decline membership.</li>
								<li>The membership shall consist of natural persons that participate in the activities of the organisation.</li>
								<li>Members of the organisation must attend its annual general meetings. At the annual general meeting members exercise their right to determine the policy of the organisation.</li>
								<li>Members must agree to uphold the Acceptable Usage Policy (AUP) as published and amended from time to time.</li>
							</ol>
						<li style="text-align: justify;">Suspension and Termination of membership:</li>
							<ol style="text-align: justify;">
								<li>A member may terminate his membership of the organisation at any time in writing to the Management Committee;</li>
								<li>A member&#8217;s membership may be suspended and/or terminated by a majority vote of the members of the organisation;</li>
								<li>The Management Committee shall have the power, in its sole and absolute discretion, to suspend and/or terminate a members membership if:</li>
									<ol>
										<li>the member is guilty of conduct detrimental to the constitution and/or interests and/or objects of the organisation;</li>
										<li>or the member, after written notice by the organisation, fails to pay the prescribed membership fee that may be due and payable within 90 days of the due date for payment of membership fees or within a reasonable time of such notice, whichever is the greater; or</li>
										<li>the member after reasonable written notice fails to comply with all or any of the terms and conditions of membership determined by the Management Committee from time to time</li>
									</ol>
								<li>The Management Committee shall notify a member of such suspension and/or termination and shall furnish its reasons for suspending and/or terminating a member&#8217;s membership to that member, in writing.</li>
								<li>A member whose membership has been terminated shall remain liable for all sums that may at the date of termination of his membership be due by him to the organisation and shall not be entitled to any refund of any monies already paid nor have any claim against the organisation of whatever nature and for whatever cause.</li>
								<li>Suspension shall be for a defined period of time or until the happening of a defined or ascertainable event, where after such members membership shall be reinstated. During such suspension, the member shall remain liable for the payment of membership fees but not enjoy voting rights and shall forfeit such other rights of members, as noted by the Management Committee in the suspension notice it shall not be necessary to suspend a members membership before terminating such membership.</li>
							</ol>
						<li style="text-align: justify;">Structure of the Management Committee</li>
							<ol style="text-align: justify;">
								<li>A management committee will manage the organisation. The management committee will be made up of not less than six (6) members elected at a general meeting of the organisation. They are the office bearers of the organisation.</li>
								<li>The management committee must elect a Chairperson, a Secretary and a Treasurer from the elected members.</li>
								<li>The Chairperson will be responsible for chairing meetings of the organisation and ensuring that decisions and resolutions are carried out.</li>
								<li>The Secretary will be responsible for the record keeping of the organisation.</li>
								<li>The Treasurer will be responsible for the management of and reporting on the funds that are held by the organisation.</li>
								<li>Additional responsibilities and roles may be defined within the management committee from time to time.</li>
								<li>Office bearers will serve for one year, but they can stand for re-election for up to three (3) full terms in succession.</li>
								<li>If a member of the management committee does not attend three management committee meetings in a row, without having applied for and obtaining leave of absence from the management committee, then the management committee may find a new member to take that person's place.</li>
								<li>The management committee will be entitled, but not obliged, from time to time to co-opt such additional members to the management committee to assist the management committee with specified projects. Such co-opted members shall not, for the purpose of this Constitution, be deemed to be members of the management committee.</li>
								<li>All members of the organisation have to abide by decisions that are taken by the management committee.</li>
							</ol>
						<li style="text-align: justify;">Powers of the organisation</li>
							<ol style="text-align: justify;">
								<li>The management committee may take on the power and authority that it believes it needs to be able to achieve the objectives that are stated in point number 3 of this constitution. Its activities must abide by the law.</li>
								<li>The management committee has the power and authority to raise funds or to invite and receive contributions.</li>
								<li>The Management Committee shall be entitled to incur expenditure in the furtherance of its duties and take action in all matters on behalf of the organisation.</li>
								<li>The management committee has the right to make by-laws for proper management, including procedure for application, approval and termination of membership.</li>
							</ol>
						<li style="text-align: justify;">Management Committee meetings and procedures</li>
							<ol style="text-align: justify;">
								<li>The management committee shall hold not less than 1 (one) meeting during every two month period and may choose to hold additional meetings of the management committee, as and when necessary to the fulfilment of the Management Committees duties. Attendance by at least half the members of the management committee shall constitute a quorum and decisions made may be carried forward.</li>
								<li>Management committee meetings may be conducted in person or via remote participation.</li>
								<li>The chairperson shall act as the chairperson of the management committee. If the chairperson does not attend a meeting, then members of the committee who are present choose which one of them will chair that meeting. This must be done before the meeting starts.</li>
								<li>Minutes will be taken at every meeting to record the management committee's decisions. The minutes of each meeting will be given to management committee members at least two weeks before the next meeting. The minutes shall be confirmed as a true record of proceedings, by the next meeting of the management committee, and shall thereafter be signed by the chairperson.</li>
								<li>When necessary, the management committee will vote on issues. If the votes are equal onan issue, then the chairperson has either a second or a deciding vote.</li>
								<li>The chairperson, or two members of the committee, can call a special meeting if they want to. But they must let the other management committee members know the date of the proposed meeting not less than 21 days before it is due to take place. They must also tell the other members of the committee which issues will be discussed at the meeting. If, however, one of the matters to be discussed is to appoint a new management committee member, then those calling the meeting must give the other committee members not less than 30 days notice.</li>
							</ol>
						<li style="text-align: justify;">General Meetings and procedures</li>
							<ol style="text-align: justify;">
								<li>The management committee must call at least two general meetings each year.</li>
								<li>General meetings shall be called by the management committee and must be announced to members at least 21 days prior to the meeting.</li>
								<li>All general meetings will be open to all members and to any other interested observer at the discretion of the Management Committee.</li>
								<li>A quorum for general meetings shall be ten percent of all members of the organisation, present in person or via remote participation.</li>
								<li>Each member shall have one vote at each meeting.</li>
								<li>The Management Committee shall report on its activities and the affairs of the organisation at all general meetings of the members.</li>
								<li>The Chairperson shall preside at all meetings at which he or she is present and shall enforce observance of the Constitution, sign minutes of meetings after confirmation, exercise supervision over the affairs of the organisation and perform such duties as customarily pertain to the office of Chairperson.</li>
								<li>Minutes of all meetings must be kept safely and always be on hand for members to consult.</li>
							</ol>
						<li style="text-align: justify;">Annual general meetings</li>
							<ol style="text-align: justify;">
								<li>The annual general meeting must be held once every year, towards the end of the organisation's financial year.</li>
								<li>The organisation should deal with the following business, amongst others, at its annual general meeting:</li>
									<ol>
										<li>Agree to the items to be discussed on the agenda.</li>
										<li>Write down who is there and who has sent apologies because they cannot attend.</li>
										<li>Read and confirm the previous meeting's minutes with matters arising.</li>
										<li>Chairperson's report.</li>
										<li>Treasurer's report.</li>
										<li>Changes to the constitution that members may want to make.</li>
										<li>Elect new office bearers.</li>
									</ol>
								<li>General.</li>
								<li>Close the meeting.</li>
							</ol>
						<li style="text-align: justify;">Finance</li>
							<ol style="text-align: justify;">
								<li>An accounting officer shall be appointed at the annual general meeting. His or her duty is to audit and check on the finances of the organisation.</li>
								<li>The Treasurer shall be responsible to the members through the Management Committee for ensuring the proper collection, administration and disbursement of the funds of the organisation and that all legal and fiscal requirements are met.</li>
								<li>The treasurer shall open and/or maintain a banking account at a registered financial institution. The organisation&#8217;s finances shall be conducted via this banking account.</li>
								<li>Whenever funds are taken out of the bank account, at least two members of the management committee must authorise the transaction.</li>
								<li>The financial year of the organisation ends on 30th June.</li>
								<li>The organisation's accounting records and reports must be ready and handed to the Director of Nonprofit Organisations within six months after the financial year end.</li>
								<li>If the organisation has funds that can be invested, the funds may only be invested with registered financial institutions. These institutions are listed in Section 1 of the Financial Institutions (Investment of Funds) Act, 1984. Or the organisation can get securities that are listed on a licensed stock exchange as set out in the Stock Exchange Control Act, 1985. The organisation can go to different banks to seek advice on the best way to look after its funds.</li>
								<li>The Management Committee may accept unconditional offers from members or any other organisations to pay for special projects undertaken by the organisation.</li>
								<li>The Management Committee will be entitled to charge special levies to members from time to time to fund special projects of the organisation which are necessary for or ancillary to the organisation&#8217;s mission as contemplated in 3 above, provided that such a special levy will have to be accepted by a majority of the membership as well.</li>
							</ol>
						<li style="text-align: justify;">Changes to the constitution</li>
							<ol style="text-align: justify;">
								<li>The constitution can be changed by a resolution. The resolution has to be agreed upon and passed by not less than two thirds of the members who are at the annual general meeting or special general meeting. Members must vote at this meeting to change the constitution.</li>
								<li>A quorum must be attained before the resolution can be passed.</li>
								<li>A written notice must go out not less than thirty (30) days before the meeting at which the changes to the constitution are going to be proposed. The notice must indicate the proposed changes to the constitution that will be discussed at the meeting.</li>
								<li>No amendments may be made which would have the effect of making the organisation cease to exist.</li>
							</ol>
						<li style="text-align: justify;">Miscellaneous</li>
							<ol style="text-align: justify;">
								<li>The organisation&#8217;s address lists and membership databases may not be used for any purpose other than the business of the organisation, unless with the prior approval of the Management Committee.</li>
								<li>Where this Constitution refers to a vote or voting, such vote or voting may take place in person, by proxy or electronically, provided that any electronic voting process is reasonably capable of providing a functional equivalent of an in person vote.</li>
							</ol>
						<li style="text-align: justify;">Dissolution/Winding-up</li>
							<ol>
								<li style="text-align: justify;">The organisation may close down if at least two-thirds of the members present and voting at a special general meeting convened for the purpose of considering such matter, are in favour of closing down.</li>
								<li style="text-align: justify;">When the organisation closes down it has to pay off all its debts. After doing this, if there is property or money left over it should not be paid or given to members of the organisation. It should be given in some way to another nonprofit organisation that has similar objectives. The organisation's general meeting will decide what organisation this should be.</li>
							</ol>
					</ol>				
				</div>

		</div> <!-- /container -->	


			<div class="form-group">
				<label class="col-lg-9 control-label">Accept Constitution aka "Terms and conditions"</label>
				<div class="col-lg-3">
					<input type="checkbox" name="tandc" value="agreed" /> .
				</div>
			</div>
		
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-10">
					<button class="btn btn-primary" id="sendcv" type="submit">Submit details!</button>
<!--					<button type="submit" class="btn btn-primary">Sign up</button> -->
				</div>
			</div>
		</form>
<!--<progress value="0" max="100" style="width:500px" class="hidden-xs"></progress>
<progress value="0" max="100" style="width:300px" class="visible-xs"></progress> -->
</div>
