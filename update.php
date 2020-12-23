<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>update</title>
    <?php require 'iniconfig.php' ?>
  </head>
  <body>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item ml-auto" role="presentation">
        <a class="nav-link active" href="#update-country" id="update-country-tab" data-toggle="tab" role="tab" aria-controls="update-country" aria-selected="true">Country</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#update-population" id="update-population-tab" data-toggle="tab" role="tab" aria-controls="update-population" aria-selected="false">Population</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#update-economy" id="update-economy-tab" data-toggle="tab" role="tab" aria-controls="update-economy" aria-selected="false">Economy</a>
      </li>
      <li class="nav-item" role="presentation">
        <a  class="nav-link" href="#update-enviroment" id="update-enviroment-tab" data-toggle="tab" role="tab" aria-controls="update-enviroment" aria-selected="false">Enviroment</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#update-military" id="update-military-tab" data-toggle="tab" role="tab" aria-controls="update-military" aria-selected="false">Mititary</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#update-crime" id="update-crime-tab" data-toggle="tab" role="tab" aria-controls="update-crime" aria-selected="false">Crime</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#update-contribution" id="update-contribution-tab" data-toggle="tab" role="tab" aria-controls="update-contribution" aria-selected="false">Contribution To Techonology</a>
      </li>
      <li class="nav-item mr-auto" role="presentation">
        <a class="nav-link" href="#update-eduhealth" id="update-eduhealth-tab" data-toggle="tab" role="tab" aria-controls="update-eduhealth" aria-selected="false">Education and Health</a>
      </li>
    </ul>
    <!--________________________________tab content for update module__________________________________-->
    <form method="post">
    <div class="tab-content">
      <!--_____________________________country________________________________-->
      <div class="tab-pane fade show active container" id="update-country" role="tabpanel" aria-labelledby="update-country-tab">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="flag">Flag: </label>
            <input class="form-control-file" type="file" name="flag" id="flag">
          </div>
      </div>
                <!--_____________________________population________________________________-->
      <div class="tab-pane fade container" id="update-population" role="tabpanel" aria-labelledby="update-population-tab">
        <form method="post">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="population">Population: </label>
            <div class="col-4">
              <input class="form-control" type="number" name="population" id="population">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="birth_rt">Birth Rate: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="birth_rt" id="birth_rt">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="death_rt">Death Rate: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="death_rt" id="death_rt">
            </div>
          </div>
      </div>
                <!--_____________________________economy________________________________-->
      <div class="tab-pane fade container" id="update-economy" role="tabpanel" aria-labelledby="update-economy-tab">
        <form method="post">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="gdp">GDP: </label>
            <div class="col-4">
              <input class="form-control" type="number" name="gdp" id="gdp">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="percap">Percapita: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="percap" id="percap">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="povper">Poverty Percentage: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="povper" id="povper">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="cur">Currency: </label>
            <div class="col-6">
              <input class="form-control" type="text" name="cur" id="cur">
            </div>
          </div>
      </div>
      <!--______________________________enviroment___________________________________-->
      <div class="tab-pane fade container" id="update-enviroment" role="tabpanel" aria-labelledby="update-enviroment-tab">
        <form method="post">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="epi">EPI Score: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="epi" id="epi">
            </div>
          </div>
      </div>
      <!---_________________________________military___________________________________-->
      <div class="tab-pane fade container" id="update-military" role="tabpanel" aria-labelledby="update-military-tab">
        <form method="post">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="m_budget">Military Budget: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="m_budget" id="m_budget">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="personnel">Personnel: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="personnel" id="personnel">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="nuke">Nuclear Warheads: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="nuke" id="nuke">
            </div>
          </div>
      </div>
      <!--___________________________________crime_________________________________-->
      <div class="tab-pane fade container" id="update-crime" role="tabpanel" aria-labelledby="update-crime-tab">
        <form method="post">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="crime_rt">Crime Rate: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="crime_rt" id="crime_rt">
            </div>
          </div>
      </div>
      <!--________________________________________techonology_______________________________-->
      <div class="tab-pane fade container" id="update-contribution" role="tabpanel" aria-labelledby="update-contribution-tab">
        <form method="post">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="c_doc">Cited Documents: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="c_doc" id="c_doc">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="cb_doc">Citable Documnets: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="cb_doc" id="cb_doc">
            </div>
          </div>
      </div>
      <!--__________________________________education and health______________________________-->
      <div class="tab-pane fade container" id="update-eduhealth" role="tabpanel" aria-labelledby="update-eduhealth-tab">
          <div class="form-group my-4">
            <label for="country_name">Country Name:</label>
            <div class="col-6">
              <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="h_index">Health Index: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="h_index" id="h_index">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="lit_rt">Literacy Rate: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="lit_rt" id="lit_rt">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="l_exp">Life Expectancy: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="l_exp" id="l_exp">
            </div>
          </div>
          <div class="form-group my-4">
            <label for="h_budget">Health Budget: </label>
            <div class="col-3">
              <input class="form-control" type="number" name="h_budget" id="h_budget">
            </div>
          </div>
        </div>
    </div>
    <div class="form-group row">
      <div class="mx-auto position-absolute submitbtn">
        <button class="btn btn-primary" type="submit" name="update" value="update">Update</button>
        <button class="btn btn-primary" type="submit" name="preview">Preview</button>
      </div>
    </div>
  </form>
    <!--________________________end of tab content for update module________________________-->
    <!--/////////////////////////////___end of update module_\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->

  </body>
</html>
