var sfcc$ = {};
sf$.doSetup=false;
sfjq$(document).ready(function() {
  // Required values: Customer specific values
sf$.token="90121";

sf$.showSmartFormAlerts=false; // set to false after a successful configuration
sf$.showCriticalAlerts=false; // set to false after a successful configuration


// Required mapping: Input field ID mapping for required end user company input data
sf$.companyNameFieldAlias="Company";

// Input field ID mappings for additional end user company input data
sf$.phoneFieldAlias="Phone";

// Input field ID mappings for additional data that can be used in the remediation process
sf$.firstNameFieldAlias="FirstName";
sf$.lastNameFieldAlias="LastName";
sf$.emailFieldAlias="Email";

// Optional mappings: Hidden field ID mappings for MATCHED company append data
sf$.mCompanyNameFieldAlias="RF_MS_Company_Name__c";
sf$.mAddr1FieldAlias="RF_MS_Address1__c";
sf$.mAddr2FieldAlias="RF_MS_Address2__c";
sf$.mCityFieldAlias="RF_MS_City__c";
sf$.mStateFieldAlias="RF_MS_State_Name__c";
sf$.mZipFieldAlias="RF_MS_postal_Code__c";
sf$.mPhoneFieldAlias="RF_MS_Phone__c";
sf$.mTradeNameFieldAlias="RF_MS_Trade_Name__c";
sf$.mStateCodeFieldAlias="RF_MS_State_Code__c";
sf$.mEmplyeeCountFieldAlias="RF_MS_Employee_Total_Count__c";
sf$.mEmplyeeHereFieldAlias="RF_MS_Employee_Location_Count__c";
sf$.mAnnualRevFieldAlias="RF_MS_Annual_Revenue__c";
sf$.mSicFieldAlias="RF_MS_SIC_Code__c";
sf$.mSicNameFieldAlias="RF_MS_SIC_Name__c";
sf$.mNaicsFieldAlias="RF_MS_NAIC_Code__c";
sf$.mNaicsNameFieldAlias="RF_MS_NAICS_Name__c";
sf$.mUrlFieldAlias="RF_MS_URL__c";
sf$.mLocationTypeFieldAlias="RF_MS_Location_Type__c";
sf$.mSubsidiaryFieldAlias="RF_MS_Subsidiary_Code__c";

// Optional mappings: Hidden field ID mappings for HEADQUARTER company append data
sf$.hqCompanyNameFieldAlias="RF_HQ_Company_Name__c";

// Optional mappings: Hidden field ID mappings for DOMESTIC HEADQUARTER company append data

// Optional mappings: Hidden field ID mappings for GLOBAL HEADQUARTER company append data

// Optional mappings: Hidden field ID mappings for inferred geo-IP append data
sf$.inferredCityFieldAlias="RF_MS_Inferred_City__c";
sf$.inferredStateFieldAlias="RF_MS_Inferred_State__c";
sf$.inferredCountryFieldAlias="RF_MS_Inferred_Country__c";
sf$.inferredAreaCodeFieldAlias="RF_MS_Inferred_Area_Code__c";

   // Required mappings:
   sf$.smartFormID=sfjq$("form[id^='mktoForm_']").not(sfjq$("form[name^='search']")).attr("id") || "smartForm1"; // "mktForm_1151"
   sf$.confidenceLevelFieldAlias="RF_MS_Confidence_Level__c"; // Field ID to hold the confidence level of a company remediation

// Required configuration: Select list view customization values.
sf$.selectListHoverColor="#f0f8ff"; // RGB color of the row with the mouse over it.

  sfcc$.checkFormExist = setInterval(function() {
          if (sfjq$("#" + sf$.grabInputID(sf$.companyNameFieldAlias)).length) {
              sfcc$.formID=sfjq$("input[name=formid]").val();

              if (typeof Mkto === "object" && typeof Mkto.formSubmit === "function") {
                  // Mkto Forms 1.0 submit injection
                  sf$.smartFormID="mktForm_" + sfcc$.formID;
                  sf$.overrideSubmit=true;
              } else {
                  // Mkto Forms 2.0 submit injection
                  sf$.smartFormID="mktoForm_" + sfcc$.formID;
                  sf$.overrideSubmit=false;
              }

              sf$.assignIDsByName=true;
              sf$.doSetup=true;
              sf$.runSFSetup();

              if (!sf$.overrideSubmit) {
                  sfcc$.doAppend=true;
                  sfcc$.form=MktoForms2.getForm(sfcc$.formID);
                  sfcc$.form.onSubmit(function() {
                      if (typeof sf$.forceSelection === "function" && sfcc$.doAppend && sf$.formCheck()) {
                          sfcc$.form.submitable(false)
                          sfcc$.doAppend = false;
                          sf$.forceSelection();
                          return false;
                      }
                      // return true to allow submit when SF submit injection completes - submit request initiated with sf$.doSmartFormSubmit()
                      return true;
                  });

                  // override sf$.doSmartFormSubmit() so that we force an original form submit, not a scripted form.submit()
                  sf$.doSmartFormSubmit = function() {
                      sfcc$.form.submitable(true);
                      sfjq$("#"+sf$.smartFormID+" :submit").removeAttr("disabled").click();
                  };
              }

              clearInterval(sfcc$.checkFormExist);
          }
      }, 100);
  });