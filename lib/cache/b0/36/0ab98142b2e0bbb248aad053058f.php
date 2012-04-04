<?php

/* index.html */
class __TwigTemplate_b0360ab98142b2e0bbb248aad053058f extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\" class=\"no-js\">
<head>
    <meta charset=\"utf-8\" />
    
    <title>";
        // line 6
        if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
        if ($this->getAttribute($_meta_, "title")) {
            if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
            echo $this->getAttribute($_meta_, "title");
            echo " | ";
        }
        if (isset($context["site_title"])) { $_site_title_ = $context["site_title"]; } else { $_site_title_ = null; }
        echo $_site_title_;
        echo "</title>
    ";
        // line 7
        if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
        if ($this->getAttribute($_meta_, "description")) {
            echo "<meta name=\"description\" content=\"";
            if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
            echo $this->getAttribute($_meta_, "description");
            echo "\">";
        }
        // line 8
        echo "    ";
        if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
        if ($this->getAttribute($_meta_, "robots")) {
            echo "<meta name=\"robots\" content=\"";
            if (isset($context["meta"])) { $_meta_ = $context["meta"]; } else { $_meta_ = null; }
            echo $this->getAttribute($_meta_, "robots");
            echo "\">";
        }
        // line 9
        echo "    
    <link rel=\"stylesheet\" href=\"";
        // line 10
        if (isset($context["theme_url"])) { $_theme_url_ = $context["theme_url"]; } else { $_theme_url_ = null; }
        echo $_theme_url_;
        echo "/style.css\" type=\"text/css\" media=\"screen\" />

    <!--[if IE]>
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\">
\t<script type=\"text/javascript\" src=\"https://html5shiv.googlecode.com/svn/trunk/html5.js\"></script>
    <![endif]-->
    <script src=\"";
        // line 16
        if (isset($context["theme_url"])) { $_theme_url_ = $context["theme_url"]; } else { $_theme_url_ = null; }
        echo $_theme_url_;
        echo "/scripts/modernizr-1.7.min.js\"></script>
</head>
<body>

    ";
        // line 20
        if (isset($context["content"])) { $_content_ = $context["content"]; } else { $_content_ = null; }
        echo $_content_;
        echo "

</body>
</html>";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 20,  55 => 16,  45 => 10,  42 => 9,  33 => 8,  25 => 7,  14 => 6,  7 => 1,);
    }
}
