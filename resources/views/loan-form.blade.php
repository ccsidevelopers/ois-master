<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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

{{-- Nag dagdag kame ng comment dito --}}
{{-- another comment di pa namen napapagana --}}
<body>
    <div class="main mh-100 main bg-light ">
        <div class="main-form d-flex align-items-center justify-content-center p-5">
            <form action="" class="form-body w-75 bg-white shadow p-4">
                <div class="row border-bottom border-3 border-primary py-3">
                    <h1 class="text-uppercase">Loan application form</h1>
                </div>
                <div class="main-form">
                    <div class="typeOfLoan row border-bottom border-3 border-primary py-3">
                        <div class="form-group col-md-4 py-2">
                            <label >What type of loan would you like to apply?</label>
                        </div>
                        <div class="form-group col-md-2 py-2">
                            <div class="my-2">
                                <input type="checkbox" class="text-uppercase" id="inputLoanMotorcycleLoan" name="selector[]" value="Motorcycle loan">
                                <label for="inputLoanMotorcycleLoan">Motorcycle Loan</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class=" text-uppercase" id="inputLoanAutoLoan" name="selector[]" value="Auto loan">
                                <label for="inputLoanAutoLoan">Auto loan</label>
                            </div>
                        </div>
                        <div class="form-group col-md-4 py-2">
                            <div class="my-2">
                                <input type="checkbox" class=" text-uppercase" id="inputLoanPersonalLoan" name="selector[]" value="Personal loan">
                                <label for="inputLoanPersonalLoan">Personal / Salary Loan</label>
                            </div>
                            <div class="my-2">
                                <input type="checkbox" class=" text-uppercase" id="inputLoanHomeLoan" name="selector[]" value="Home loan">
                                <label for="inputLoanHomeLoan">Home / Housing Loan</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-uppercase pt-3">
                        <h3>Personal Information</h3>
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
                            <label for="inputLoanMobileNumber" class="pb-2">Personal Mobile Number</label>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanMobileNumber" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanEmailAddress" class="pb-2">Personal Email Address</label>
                            <input type="text" class="form-control form-control-sm" id="inputLoanEmailAddress" placeholder="OPTIONAL">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanHomeNumber" class="pb-2">Home Landline Number</label>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanHomeNumber" placeholder="optional">
                        </div>
                        <div class="form-group col-md-3"></div>
                    </div>
                    <div class="row pt-4">
                        <h5>Present Address</h5>
                        <div class="form-group col-md-6">
                            <label for="inputLoanPresentAddress1" class="pb-2">Unit #, Bldg/Street, Subd/Brgy.</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPresentAddress1" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanPresentAddress2" class="pb-2">City/Municipality</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPresentAddress2" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanPresentAddress3" class="pb-2">Province</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPresentAddress3" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-6">
                            <input type="checkbox" name="" id="inputLoanSameAddressCheck">
                            <label for="inputLoanSameAddressCheck">Check (if your present address is also your permanent address)</label>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <h5>Permanent Address</h5>
                        <div class="form-group col-md-6">
                            <label for="inputLoanPermanentAddress1" class="pb-2">Unit #, Bldg/Street, Subd/Brgy.</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPermanentAddress1" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanPermanentAddress2" class="pb-2">City/Municipality</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPermanentAddress2" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanPermanentAddress3" class="pb-2">Province</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanPermanentAddress3" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-6">
                            <label for="inputLoanWorkEmailAddress">Work Email Address</label>
                            <input type="text" class="form-control form-control-sm" id="inputLoanWorkEmailAddress" placeholder="OPTIONAL">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanWorkLandlineNumber">Work Landline Number</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanWorkLandlineNumber" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4 border-bottom border-3 border-primary py-3">
                        <h5>Work Address</h5>
                        <div class="form-group col-md-6">
                            <label for="inputLoanWorkAddress1" class="pb-2">Unit #, Bldg/Street, Subd/Brgy.</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanWorkAddress1" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanWorkAddress2" class="pb-2">City/Municipality</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanWorkAddress2" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanWorkAddress3" class="pb-2">Province</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanWorkAddress3" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-4">
                            <label for="inputLoanBirthdate" class="pb-2">Birthdate</label>
                            <input type="date" class="form-control form-control-sm text-uppercase" id="inputLoanBirthdate" placeholder="Required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputLoanBirthPlace" class="pb-2">Birth Place</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanBirthPlace" placeholder="Required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputLoanCitizenship" class="pb-2">Citizenship</label>
                            <div class="">
                                <input type="checkbox" class="text-uppercase chbCitizenship" id="inputLoanCitizenshipFilipino" name="citizenship" value="Filipino" checked="true">
                                <label for="inputLoanCitizenshipFilipino">Filipino</label>
                            </div>
                            <div class="">
                                <input type="checkbox" class="text-uppercase chbCitizenship" id="inputLoanCitizenshipOthers" name="citizenship" value="">
                                <label for="inputLoanCitizenshipOthers">Others</label>
                                <input type="text" class="text-uppercase w-50" id="inputLoanCitizenshipOthersEnter" placeholder="Optional" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-4">
                            <label for="">Gender</label>
                            <div>
                                <div>
                                    <input type="radio" name="gender" class="" id="inputLoanMaleGender" value="Male">
                                    <label for="inputLoanMaleGender">Male</label>
                                </div>
                                <div>
                                    <input type="radio" name="gender" class="" id="inputLoanFemaleGender" value="Female">
                                    <label for="inputLoanFemaleGender">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputLoanCivilStatus">Civil Status</label>
                            <div>
                            <select class="civilStatus" id="inputLoanCivilStatus">
                                <option selected="" value=""></option>
                                <option value="Married">Married</option>
                                <option value="Single">Single</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputLoanHomeOwnership" class="pb-2">Home Ownership</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanHomeOwnership" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-3">
                            <label for="inputLoanSssGsisNumber" class="pb-2">SSS / GSIS Number</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSssGsisNumber" placeholder="Required">
                        </div>
                        <div class="col-md-3">
                            <label for="inputLoanTinNumber" class="pb-2">TIN Number</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanTinNumber" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4">
                        <h5>Spouse's Full Name</h5>
                        <div class="form-group col-md-3">
                            <label for="inputLoanSpouseLName" class="pb-2">Last Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSpouseLName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanSpouseFName" class="pb-2">First Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSpouseFName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanSpouseMName" class="pb-2">Middle Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSpouseMName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanSpouseSName" class="pb-2">Suffix (Sr/Jr)</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanSpouseSName" placeholder="Optional">
                        </div>
                    </div>
                    <div class="row pt-4 border-bottom border-3 border-primary py-4">
                        <h5>Mother's Maiden Name</h5>
                        <div class="form-group col-md-3">
                            <label for="inputLoanMothersMaidenLName" class="pb-2">Last Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanMothersMaidenLName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanMothersMaidenFName" class="pb-2">First Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanMothersMaidenFName" placeholder="Required">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputLoanMothersMaidenMName" class="pb-2">Middle Name</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanMothersMaidenMName" placeholder="Required">
                        </div>
                    </div>
                    <div class="text-uppercase pt-3">
                        <h3>Financial Information</h3>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-6">
                            <label class="pb-2">Source of Income (if 'Others', please indicate)</label>
                            <div class="row">
                                <div class="col-md-3 d-flex flex-column">
                                    <div class="my-1">
                                        <input type="checkbox" class="text-uppercase" id="inputLoanIncomeEmployment" name="" value="Employment">
                                        <label for="inputLoanIncomeEmployment">Employment</label>
                                    </div>
                                    <div class="my-1">
                                        <input type="checkbox" class="text-uppercase" id="inputLoanIncomeBusiness" name="" value="Business">
                                        <label for="inputLoanIncomeBusiness">Business</label>
                                    </div>
                                </div>
                                <div class="col-md-9 d-flex flex-column">
                                    <div class="my-1">
                                        <input type="checkbox" class="text-uppercase" id="inputLoanIncomePension" name="" value="Pension">
                                        <label for="inputLoanIncomePension">Pension</label>
                                    </div>
                                    <div class="my-1">
                                        <input type="checkbox" class="text-uppercase" id="inputLoanIncomeOthers" name="" value="Others">
                                        <label for="inputLoanIncomeOthers">Others</label>
                                        <input type="text" class="text-uppercase w-50" id="inputLoanIncomeOthersEnter" placeholder="Optional" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="pb-2">Employment Status (if 'Others', please indicate</label>
                            <div class="row">
                                <div class="col-md-3 d-flex flex-column">
                                    <div class="my-1">
                                        <input type="checkbox" class="chbEmploymentStatus text-uppercase chb" id="inputLoanStatusEmployed" name="employmentStatus" value="Employed">
                                        <label for="inputLoanStatusEmployed">Employed</label>
                                    </div>
                                    <div class="my-1">
                                        <input type="checkbox" class="chbEmploymentStatus text-uppercase chb" id="inputLoanStatusSelfEmployed" name="employmentStatus" value="Self Employed">
                                        <label for="inputLoanStatusSelfEmployed">Self-Employed</label>
                                    </div>
                                </div>
                                <div class="col-md-9 d-flex flex-column">
                                    <div class="my-1">
                                        <input type="checkbox" class="chbEmploymentStatus text-uppercase chb" id="inputLoanStatusRetired" name="employmentStatus" value="Retired">
                                        <label for="inputLoanStatusRetired">Retired</label>
                                    </div>
                                    <div class="my-1">
                                        <input type="checkbox" class="chbEmploymentStatus text-uppercase chb" id="inputLoanStatusOthers" name="employmentStatus" value="">
                                        <label for="inputLoanStatusOthers">Others</label>
                                        <input type="text" class="text-uppercase w-50" id="inputLoanStatusOthersEnter" placeholder="Optional" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <h5>Employment Type</h5>
                        <div class="row d-flex">
                            <div class="col-md-2">
                                <label for="">For Employed</label>
                            </div>
                            <div class="col-md-2 d-flex flex-column">
                                <div class="my-1">
                                    <input type="checkbox" class="chbForEmployed text-uppercase" id="inputLoanEmployedPrivateSector" name="forEmployed" value="Private Sector">
                                    <label for="inputLoanEmployedPrivateSector">Private Sector</label>
                                </div>
                                <div class="my-1">
                                    <input type="checkbox" class="chbForEmployed text-uppercase" id="inputLoanEmployedBSP" name="forEmployed" value="BSP">
                                    <label for="inputLoanEmployedBSP">BSP</label>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column">
                                <div class="my-1">
                                    <input type="checkbox" class="chbForEmployed text-uppercase" id="inputLoanEmployedGovernment" name="forEmployed" value="Government">
                                    <label for="inputLoanEmployedGovernment">Government</label>
                                </div>
                                <div class="my-1">
                                    <input type="checkbox" class="chbForEmployed text-uppercase" id="inputLoanEmployedNGO" name="forEmployed" value="NGO">
                                    <label for="inputLoanEmployedNGO">NGO</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="">For Self-Employed</label>
                            </div>
                            <div class="col-md-2 d-flex flex-column">
                                <div class="my-1">
                                    <input type="checkbox" class="chbForSelfEmployed text-uppercase" id="inputLoanSESProprietorship" name="forSelfEmployed" value="Single Proprietorship">
                                    <label for="inputLoanSESProprietorship">Single Proprietorship</label>
                                </div>
                                <div class="my-1">
                                    <input type="checkbox" class="chbForSelfEmployed text-uppercase" id="inputLoanSEPartnership" name="forSelfEmployed" value="Partnership">
                                    <label for="inputLoanSEPartnership">Partnership</label>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column">
                                <div class="my-1">
                                    <input type="checkbox" class="chbForSelfEmployed text-uppercase" id="inputLoanSECorporation" name="forSelfEmployed" value="Corporation">
                                    <label for="inputLoanSECorporation">Corporation</label>
                                </div>
                                <div class="my-1">
                                    <input type="checkbox" class="chbForSelfEmployed text-uppercase" id="inputLoanSEProfessional" name="forSelfEmployed" value="Professional">
                                    <label for="inputLoanSEProfessional">Professional</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-8">
                            <label for="inputLoanEmpBusinessName" class="pb-2">Name of Employer / Business</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanEmpBusinessName" placeholder="Required">
                        </div>
                        <div class="col-md-4">
                            <label for="inputLoanJobPositionName" class="pb-2">Job Title / Position</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanJobPositionName" placeholder="Required">
                        </div>
                    </div>
                    <div class="row pt-4 border-bottom border-3 border-primary py-3">
                        <div class="col-md-4">
                            <label for="inputLoanNatureOfBusiness" class="pb-2">Nature of Business</label>
                            <input type="text" class="form-control form-control-sm text-uppercase" id="inputLoanNatureOfBusiness" placeholder="Required">
                        </div>
                        <div class="col-md-4">
                            <label for="inputLoanGAIncome" class="pb-2">Gross Annual Income (PHP)</label>
                            <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanGAIncome" placeholder="Required">
                        </div>
                        <div class="col-md-4">
                            <label for="inputLoanYearsMonthsWithEmployer" class="pb-2">Years with Employer in Business</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanYearsWithEmployer" placeholder="Required">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Yrs.</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control form-control-sm text-uppercase" id="inputLoanMonthsWithEmployer" placeholder="Required">
                                </div>
                                <div class="col-md-2">
                                    <label for="">Mos.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-4 border-bottom border-3 border-primary py-3">
                        <div class="text-uppercase pt-3">
                            <h3>Attachment of ID's</h3>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="scol-md-4 py-3">
                                <label for="inputLoanAttachmentOfId" class="pb-2">ID with Signature</label>
                                <input type="file" class="form-control form-control-sm text-uppercase" id="inputLoanAttachmentOfId" name="myfile">
                            </div>
                        </div>
                    </div>
                    <div class="pt-3">
                        <h2 class="text-uppercase">Disclamer</h2>
                        <p class="pt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti alias, iste labore quibusdam error dolor fugit necessitatibus dolore odio nostrum officia voluptatum. Qui, corrupti tenetur animi obcaecati provident voluptate recusandae!
                        Blanditiis qui, totam modi quos adipisci mollitia praesentium consequuntur eaque ratione perferendis, provident, fugiat neque laborum numquam quo nemo nam. Quod doloremque rerum mollitia adipisci sequi saepe corporis necessitatibus odit!
                        Itaque nulla harum maxime aliquid rem? Minima, excepturi animi ipsam ex eius itaque! Tenetur ea aperiam doloribus numquam. Ipsum quam itaque culpa reiciendis nulla molestias error veniam iusto tempore accusantium?
                        Tenetur repellat, nihil eum dignissimos, fuga unde natus laboriosam eius totam cumque sequi maiores nostrum sit. Aliquam, libero suscipit perspiciatis voluptates omnis aut voluptatum deserunt accusantium vero harum distinctio quia.
                    </p>
                    <div class="agree text-end">
                        <input type="checkbox" id="inputLoanAgreeChb">
                        <label for="">I agree to the Terms and Conditions.</label>
                    </div>
                    </div>
                    <div class="row pt-4">
                        <div class="form-group col-md-12 text-end">
                            <button id="submitKioskLoanBtn" type="submit" class="btn btn-primary btn-not" disabled>Submit</button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="jscript/loan-form.js"></script>
</body>
</html>