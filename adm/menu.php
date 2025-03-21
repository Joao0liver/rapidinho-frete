<?php

session_start();

if($_SESSION['id_user'] == '' || $_SESSION['email_user'] == null || $_SESSION['nivel_user'] <> 777){
    
    header('Location: ../forms/index.php');
    exit();
    
}else{

    include_once("../conexao.php");
    include_once("../funcoes.php");
    include_once("../layout/header_adm.php");

    $id_user = $_SESSION['id_user'];

    $sql = "SELECT nome_user FROM tbl_usuario WHERE id_user = $id_user";
    $rodar_sql = mysqli_query($conn, $sql);
    $nome_user = mysqli_fetch_assoc($rodar_sql);

?>

<!-- Blank Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Vendas do Dia</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Vendas do Mês</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Lucro do Dia</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Lucro do Mês</p>
                                <h6 class="mb-0">$1234</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-md-6 col-xl-4">
                        <div class="h-100 bg-light rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Calender</h6>
                                <a href="">Show All</a>
                            </div>
                            <div id="calender"><div class="bootstrap-datetimepicker-widget usetwentyfour"><ul class="list-unstyled"><li class="show"><div class="datepicker"><div class="datepicker-days" style=""><table class="table table-sm"><thead><tr><th class="prev" data-action="previous"><span class="fa fa-chevron-left" title="Previous Month"></span></th><th class="picker-switch" data-action="pickerSwitch" colspan="5" title="Select Month">March 2025</th><th class="next" data-action="next"><span class="fa fa-chevron-right" title="Next Month"></span></th></tr><tr><th class="dow">Su</th><th class="dow">Mo</th><th class="dow">Tu</th><th class="dow">We</th><th class="dow">Th</th><th class="dow">Fr</th><th class="dow">Sa</th></tr></thead><tbody><tr><td data-action="selectDay" data-day="02/23/2025" class="day old weekend">23</td><td data-action="selectDay" data-day="02/24/2025" class="day old">24</td><td data-action="selectDay" data-day="02/25/2025" class="day old">25</td><td data-action="selectDay" data-day="02/26/2025" class="day old">26</td><td data-action="selectDay" data-day="02/27/2025" class="day old">27</td><td data-action="selectDay" data-day="02/28/2025" class="day old">28</td><td data-action="selectDay" data-day="03/01/2025" class="day weekend">1</td></tr><tr><td data-action="selectDay" data-day="03/02/2025" class="day weekend">2</td><td data-action="selectDay" data-day="03/03/2025" class="day">3</td><td data-action="selectDay" data-day="03/04/2025" class="day">4</td><td data-action="selectDay" data-day="03/05/2025" class="day">5</td><td data-action="selectDay" data-day="03/06/2025" class="day">6</td><td data-action="selectDay" data-day="03/07/2025" class="day">7</td><td data-action="selectDay" data-day="03/08/2025" class="day weekend">8</td></tr><tr><td data-action="selectDay" data-day="03/09/2025" class="day weekend">9</td><td data-action="selectDay" data-day="03/10/2025" class="day">10</td><td data-action="selectDay" data-day="03/11/2025" class="day">11</td><td data-action="selectDay" data-day="03/12/2025" class="day">12</td><td data-action="selectDay" data-day="03/13/2025" class="day">13</td><td data-action="selectDay" data-day="03/14/2025" class="day">14</td><td data-action="selectDay" data-day="03/15/2025" class="day weekend">15</td></tr><tr><td data-action="selectDay" data-day="03/16/2025" class="day weekend">16</td><td data-action="selectDay" data-day="03/17/2025" class="day active today">17</td><td data-action="selectDay" data-day="03/18/2025" class="day">18</td><td data-action="selectDay" data-day="03/19/2025" class="day">19</td><td data-action="selectDay" data-day="03/20/2025" class="day">20</td><td data-action="selectDay" data-day="03/21/2025" class="day">21</td><td data-action="selectDay" data-day="03/22/2025" class="day weekend">22</td></tr><tr><td data-action="selectDay" data-day="03/23/2025" class="day weekend">23</td><td data-action="selectDay" data-day="03/24/2025" class="day">24</td><td data-action="selectDay" data-day="03/25/2025" class="day">25</td><td data-action="selectDay" data-day="03/26/2025" class="day">26</td><td data-action="selectDay" data-day="03/27/2025" class="day">27</td><td data-action="selectDay" data-day="03/28/2025" class="day">28</td><td data-action="selectDay" data-day="03/29/2025" class="day weekend">29</td></tr><tr><td data-action="selectDay" data-day="03/30/2025" class="day weekend">30</td><td data-action="selectDay" data-day="03/31/2025" class="day">31</td><td data-action="selectDay" data-day="04/01/2025" class="day new">1</td><td data-action="selectDay" data-day="04/02/2025" class="day new">2</td><td data-action="selectDay" data-day="04/03/2025" class="day new">3</td><td data-action="selectDay" data-day="04/04/2025" class="day new">4</td><td data-action="selectDay" data-day="04/05/2025" class="day new weekend">5</td></tr></tbody></table></div><div class="datepicker-months" style="display: none;"><table class="table-condensed"><thead><tr><th class="prev" data-action="previous"><span class="fa fa-chevron-left" title="Previous Year"></span></th><th class="picker-switch" data-action="pickerSwitch" colspan="5" title="Select Year">2025</th><th class="next" data-action="next"><span class="fa fa-chevron-right" title="Next Year"></span></th></tr></thead><tbody><tr><td colspan="7"><span data-action="selectMonth" class="month">Jan</span><span data-action="selectMonth" class="month">Feb</span><span data-action="selectMonth" class="month active">Mar</span><span data-action="selectMonth" class="month">Apr</span><span data-action="selectMonth" class="month">May</span><span data-action="selectMonth" class="month">Jun</span><span data-action="selectMonth" class="month">Jul</span><span data-action="selectMonth" class="month">Aug</span><span data-action="selectMonth" class="month">Sep</span><span data-action="selectMonth" class="month">Oct</span><span data-action="selectMonth" class="month">Nov</span><span data-action="selectMonth" class="month">Dec</span></td></tr></tbody></table></div><div class="datepicker-years" style="display: none;"><table class="table-condensed"><thead><tr><th class="prev" data-action="previous"><span class="fa fa-chevron-left" title="Previous Decade"></span></th><th class="picker-switch" data-action="pickerSwitch" colspan="5" title="Select Decade">2020-2029</th><th class="next" data-action="next"><span class="fa fa-chevron-right" title="Next Decade"></span></th></tr></thead><tbody><tr><td colspan="7"><span data-action="selectYear" class="year old">2019</span><span data-action="selectYear" class="year">2020</span><span data-action="selectYear" class="year">2021</span><span data-action="selectYear" class="year">2022</span><span data-action="selectYear" class="year">2023</span><span data-action="selectYear" class="year">2024</span><span data-action="selectYear" class="year active">2025</span><span data-action="selectYear" class="year">2026</span><span data-action="selectYear" class="year">2027</span><span data-action="selectYear" class="year">2028</span><span data-action="selectYear" class="year">2029</span><span data-action="selectYear" class="year old">2030</span></td></tr></tbody></table></div><div class="datepicker-decades" style="display: none;"><table class="table-condensed"><thead><tr><th class="prev" data-action="previous"><span class="fa fa-chevron-left" title="Previous Century"></span></th><th class="picker-switch" data-action="pickerSwitch" colspan="5">2000-2090</th><th class="next" data-action="next"><span class="fa fa-chevron-right" title="Next Century"></span></th></tr></thead><tbody><tr><td colspan="7"><span data-action="selectDecade" class="decade old" data-selection="2006">1990</span><span data-action="selectDecade" class="decade" data-selection="2006">2000</span><span data-action="selectDecade" class="decade" data-selection="2016">2010</span><span data-action="selectDecade" class="decade active" data-selection="2026">2020</span><span data-action="selectDecade" class="decade" data-selection="2036">2030</span><span data-action="selectDecade" class="decade" data-selection="2046">2040</span><span data-action="selectDecade" class="decade" data-selection="2056">2050</span><span data-action="selectDecade" class="decade" data-selection="2066">2060</span><span data-action="selectDecade" class="decade" data-selection="2076">2070</span><span data-action="selectDecade" class="decade" data-selection="2086">2080</span><span data-action="selectDecade" class="decade" data-selection="2096">2090</span><span data-action="selectDecade" class="decade old" data-selection="2106">2100</span></td></tr></tbody></table></div></div></li><li class="picker-switch accordion-toggle"></li></ul></div></div>
                        </div>
                    </div>
                </div>
            </div>
<!-- Blank End -->

<?php

include_once("../layout/footer.php");
}

?>