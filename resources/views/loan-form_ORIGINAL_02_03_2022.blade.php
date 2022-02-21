<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>Loan form</title>
    <style>
        .logo {
            text-align: right;
        }
        .logo img {
            width: 20%;
        }
        @media screen and (max-width: 1366px) {
            .main-form {
                padding: 0 !important;
                padding-bottom: 20px !important;
            }
            .form-body {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <div class="main mh-100 main bg-light ">
        <div class="main-form d-flex align-items-center justify-content-center p-5">
            <form action="" class="form-body w-75 bg-white shadow p-4">
                <div class="main-title border-bottom border-primary text-uppercase p-3">
                    <h1>Loan application form</h1>
                </div>
                <div class="main-form">
                    <div class="row py-2">
                        <div class="form-group col-md-4 py-2">
                            <label >What type of loan would you like to apply?</label>
                        </div>
                        <div class="form-group col-md-2 py-2">
                            <div class="my-2">
                                <input type="checkbox" class="text-uppercase" id="inputLoanMotorcycleLoan" name="inputLoanMotorcycleLoan" value="Motorcycle loan">
                                <label for="inputLoanMotorcycleLoan">Motorcycle Loan</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class=" text-uppercase" id="inputLoanAutoLoan" name="inputLoanAutoLoan" value="Auto loan">
                                <label for="inputLoanAutoLoan">Auto loan</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4 py-2">
                            <div class="my-2">
                                <input type="checkbox" class=" text-uppercase" id="inputLoanPersonalLoan" name="inputLoanPersonalLoan" value="Personal loan">
                                <label for="inputLoanPersonalLoan">Personal / Salary Loan</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class=" text-uppercase" id="inputLoanHomeLoan" name="inputLoanHomeLoan" value="Home loan">
                                <label for="inputLoanHomeLoan">Home / Housing Loan</label>
                            </div>
                        </div>
                    </div>
                    <div class="sub-title border-top border-primary py-2">
                        <h2>Personal Information</h2>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-3">
                            <label for="inputLoanLName" class="pb-2">Last Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanLName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanFName" class="pb-2">First Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanFName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanMName" class="pb-2">Middle Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanMName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanSName" class="pb-2">Suffix (Sr/Jr)</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSName" placeholder="Optional">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-3">
                            <label for="inputLoanMothersMaidenName" class="pb-2">Mother's Maiden Name (Full name)</label>
                            <input type="text" class="form-control form-control-sm text-uppercase col-md-6" id="inputLoanMothersMaidenName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanSpouseName" class="pb-2">Spouse (Full Name)</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSpouseName" placeholder="Optional">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanNumOfDependents" class="pb-2">No. of dependents</label>
                            <input type="number" class="form-control form-control-sm w-50 text-uppercase" id="inputLoanNumOfDependents" placeholder="Optional">
                        </div>
                        <div class="form-group col-md-3">
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <label for="inputLoanBirthday" class="pb-2">Birthday</label>
                                    <input type="date" class="form-control form-control-sm w-100" id="inputLoanBirthday" placeholder="Required">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="inputLoanBirthday" class="pb-2">Age</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase w-100" id="inputLoanBirthday" value="24" placeholder="Auto" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-3">
                            <input type="radio" name="gender" class="" id="inputLoanMaleGender" value="Male">
                            <label for="inputLoanMaleGender">Male</label>
                            <input type="radio" name="gender" class="" id="inputLoanFemaleGender" value="Female">
                            <label for="inputLoanFemaleGender">Female</label>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanCivilStatus">Civil Status</label>
                            <select name="civil_status" id="inputLoanCivilStatus">
                                <option selected="" value=""></option>
                                <option value="Married">Married</option>
                                <option value="Single">Single</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanCitizenship" class="pb-2">Citizenship</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanCitizenship" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanNumOfYears" class="pb-2">No. of years</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanNumOfYears" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-6">
                            <label for="inputLoanPresentAddress" class="pb-2">Present Address</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPresentAddress" placeholder="Required">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputLoanPermanentAddress" class="pb-2">Permanent Address</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPermanentAddress" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-6">
                            <input type="checkbox" name="" id="inputLoanSameAddressCheck">
                            <label for="inputLoanSameAddressCheck">Check (if your present address is also your permanent address)</label>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-3">
                            <label for="inputLoanHomeNumber" class="pb-2">Home phone no.</label>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanHomeNumber" placeholder="optional">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanMobileNumber" class="pb-2">Mobile phone no.</label>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanMobileNumber" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanEmailAddress" class="pb-2">Email Address</label>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanEmailAddress" placeholder="Optional">
                        </div>
                        <div class="form-group col-md-3"></div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-3">
                            <label for="inputLoanGovernmentId" class="pb-2">Government Id's</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanGovernmentId" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanAttachmentOfId" class="pb-2">Attachment of Id's</label>
                            <input type="file" id="inputLoanAttachmentOfId" name="myfile">
                        </div>
                    </div>
                    <div class="sub-title border-top border-primary py-2 mt-5">
                        <h2>Employment/Business Information</h2>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-3">
                            <label for="inputLoanEmployerBusinessName" class="pb-2">Employer/Business name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanEmployerBusinessName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanOccupation" class="pb-2">Occupation</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanOccupation" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanEmploymentStatus" class="pb-2">Employment status</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanEmploymentStatus" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanDateEmployed" class="pb-2">Date employed</label>
                            <input type="date" class="form-control form-control-sm text-uppercase" id="inputLoanDateEmployed" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-6">
                            <label for="inputLoanEmployerBusinessAddress" class="pb-2">Employer/Business Address</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanEmployerBusinessAddress" placeholder="Required">
                        </div>
                    </div>
                    <div class="sub-title border-top py-2 mt-5">
                        <h2>Disclamer</h2>
                        <p class="pt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti alias, iste labore quibusdam error dolor fugit necessitatibus dolore odio nostrum officia voluptatum. Qui, corrupti tenetur animi obcaecati provident voluptate recusandae!
                        Blanditiis qui, totam modi quos adipisci mollitia praesentium consequuntur eaque ratione perferendis, provident, fugiat neque laborum numquam quo nemo nam. Quod doloremque rerum mollitia adipisci sequi saepe corporis necessitatibus odit!
                        Itaque nulla harum maxime aliquid rem? Minima, excepturi animi ipsam ex eius itaque! Tenetur ea aperiam doloribus numquam. Ipsum quam itaque culpa reiciendis nulla molestias error veniam iusto tempore accusantium?
                        Tenetur repellat, nihil eum dignissimos, fuga unde natus laboriosam eius totam cumque sequi maiores nostrum sit. Aliquam, libero suscipit perspiciatis voluptates omnis aut voluptatum deserunt accusantium vero harum distinctio quia.
                    </p>
                    <div class="agree text-end">
                        <input type="checkbox">
                        <label for="">I agree to the Terms and Conditions.</label>
                    </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-12 text-end">
                            <button type="submit" class="btn btn-primary" id="submitLoanBtn">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="footer  pb-3">
            <div class="details text-center">
                <small><span class="text-danger">Comprehensive Credit Services Inc.</span> | All rights reserved 2022 &copy;</small>
            </div>
        </div>
    </div>
</body>
</html>